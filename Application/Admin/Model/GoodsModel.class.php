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

    public function getCurrentDetailInfo($id)
    {
        if (!empty($id)) {
            return $this->where('gID=' . $id)->field('gID,gName,gType,gPrice,gOriginPrice,gCount,gDescription')->find();
        } else {
            return false;
        }
    }

    public function updateGoods($id, $name, $type, $price, $originPrice, $count, $desc)
    {
        if (!empty($id) && !empty($name) && !empty($type) && !empty($price) && !empty($count)) {
            $data['gID'] = $id;
            $data['gName'] = $name;
            $data['gType'] = $type;
            $data['gPrice'] = $price;
            $data['gOriginPrice'] = $originPrice;
            $data['gCount'] = $count;
            $data['gDescription'] = $desc;

            return $this->where('gID=' . $id)->save($data);
        } else {
            return false;
        }
    }
}