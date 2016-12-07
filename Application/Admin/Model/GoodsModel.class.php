<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.06
 * Time: 21:21
 */

namespace Admin\Model;

use Think\Model;

class GoodsModel extends Model
{
    public function addNewGoods($name, $type, $price, $originPrice, $count, $desc, $headerPic)
    {
        if (session('?salesUID') && !empty($name) && !empty($price) && !empty($count)) {
            if (empty($headerPic)) {
                $headerPic = DEFAULT_HEADER_PIC_PATH . 'default.jpg';
            }
            $salesUID = session('salesUID');
            $publishTime = date('Y-m-d H:i:s');

            $data['gName'] = $name;
            $data['gType'] = $type;
            $data['gPrice'] = $price;
            $data['gOriginPrice'] = $originPrice;
            $data['gCount'] = $count;
            $data['gDescription'] = $desc;
            $data['gSalesSUID'] = $salesUID;
            $data['gPubTime'] = $publishTime;
            $data['gPhoto'] = $headerPic;

            return $this->add($data);
        } else {
            return false;
        }
    }
}