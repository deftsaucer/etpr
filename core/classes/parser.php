<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/libs/phpquery/phpQuery.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/new/core/db_conn.php';

class Parser
{
    public static function getUrlContent($url, $maxAttempts = 3, $retryDelay = 2) 
    {
        $attempts = 0;
    
        while ($attempts < $maxAttempts) {
            $attempts++;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
            $html = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            if ($httpCode == 200) {
                return $html;
            } elseif ($httpCode == 404) {
                sleep($retryDelay);
            }
        }
    
        return false;
    }

    public static function parseTenderData($number)
    {
        $numLength = strlen($number);

        if ($numLength <= 12) {
            $url = 'https://zakupki.gov.ru/epz/order/notice/notice223/common-info.html?noticeInfoId=' . $number;
            $html = Parser::getUrlContent($url);

            if ($html) {
                $dom = phpQuery::newDocument($html);
                $item = $dom->find('.search-registry-entrys-block');
                $pqItem = pq($item);
            
                $arItem = [];
                $arItem['number'] = preg_replace('/[^0-9]/', '', $pqItem->find('.registry-entry__header-mid__number')->text());
                $arItem['method'] = preg_replace('/^\S+\s+/', '', trim($pqItem->find('.registry-entry__header-top__title')->text()));
                $arItem['law'] = preg_match('/^\S+/', trim($pqItem->find('.registry-entry__header-top__title')->text()), $matches) ? $matches[0] : '';
                $arItem['status'] = trim($pqItem->find('.registry-entry__header-mid__title')->text());
                $arItem['object'] = trim(preg_replace('/\s+/', ' ', $pqItem->find('.registry-entry__body-value')->eq(0)->text()));
                $arItem['customer'] = trim(preg_replace('/\s+/', ' ', $pqItem->find('.registry-entry__body-value a')->text()));
                $arItem['price'] = trim($pqItem->find('.price-block__value')->text());
                $arItem['post_date'] = trim($pqItem->find('.data-block__value')->eq(0)->text());
                $arItem['end_date'] = trim($pqItem->find('.data-block__value')->eq(2)->text());

                return $arItem;
            } else {
                return false;
            }
        } else {
            $url = 'https://zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?regNumber=' . $number;
            $html = Parser::getUrlContent($url);
            
            if ($html) {
                $dom = phpQuery::newDocument($html);
                $item = $dom->find('.cardMainInfo');
                $pqItem = pq($item);
            
                $arItem = [];
                $arItem['number'] = preg_replace('/[^0-9]/', '', $pqItem->find('.cardMainInfo__purchaseLink')->text());
                $arItem['method'] = trim($pqItem->find('.sectionMainInfo__header .cardMainInfo__title.distancedText')->text());
                $arItem['law'] = preg_match('/^\S+/', trim($pqItem->find('.sectionMainInfo__header .cardMainInfo__title')->text()), $matches) ? $matches[0] : '';
                $arItem['status'] = trim($pqItem->find('.cardMainInfo__state')->text());
                $arItem['object'] = trim(preg_replace('/\s+/', ' ', $pqItem->find('.cardMainInfo__content')->eq(0)->text()));
                $arItem['customer'] = trim(preg_replace('/\s+/', ' ', $pqItem->find('.cardMainInfo__content a')->text()));
                $arItem['price'] = trim($pqItem->find('.price .cardMainInfo__content')->text());
                $arItem['post_date'] = trim($pqItem->find('.date .cardMainInfo__content')->eq(0)->text());
                $arItem['end_date'] = trim($pqItem->find('.date .cardMainInfo__content')->eq(2)->text());

                return $arItem;
            } else {
                return false;
            }
        }
    }
}
