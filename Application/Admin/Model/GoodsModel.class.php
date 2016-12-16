<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016.12.06
 * Time: 21:21
 */

namespace Admin\Model;

use Think\Model;

/**
 * 商品模型类
 * Class GoodsModel
 * @package Admin\Model
 */
class GoodsModel extends Model
{
    /**
     * 添加商品
     * @param string $name 商品名
     * @param string $type 商品种类
     * @param double $price 商品价格
     * @param double $originPrice 商品原价
     * @param int $count 商品库存
     * @param string $desc 商品描述
     * @param string $headerPic 商品图片url
     * @return bool|mixed
     */
    public function addNewGoods($name, $type, $price, $originPrice, $count, $desc, $headerPic)
    {
        if (!empty($name) && !empty($price) && !empty($count)) {
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

    /**
     * 根据商品ID更新商品信息
     * @param int $id 商品ID
     * @param string $name 商品名称
     * @param string $type 商品种类
     * @param double $price 商品价格
     * @param double $originPrice 商品原价
     * @param int $count 商品库存
     * @param string $desc 商品描述
     * @return bool
     */
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

    /**
     * 根据商品ID删除对应商品
     * @param int $id 商品ID
     * @return bool|mixed
     */
    public function deleteGoods($id)
    {
        if (!empty($id)) {
            return $this->where('gID=' . $id)->delete();
        } else {
            return false;
        }
    }

    /**
     * 根据商品ID下架对应商品
     * @param int $id 商品ID
     * @return bool
     */
    public function shutdownGoods($id)
    {
        if (!empty($id)) {
            $nowStatus = $this->where('gID=' . $id)->getField('gStatus');
            if ($nowStatus == 1 || $nowStatus == 2) {
                return $this->where('gID=' . $id)->setField('gStatus', '0');
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商品ID重上架架对应商品
     * @param int $id 商品ID
     * @return bool
     */
    public function returnGoods($id)
    {
        if (!empty($id)) {
            $nowStatus = $this->where('gID=' . $id)->getField('gStatus');
            if ($nowStatus == 0) {
                return $this->where('gID=' . $id)->setField('gStatus', '1');
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商品ID置顶架对应商品
     * @param int $id 商品ID
     * @return bool
     */
    public function goodsRankTop($id)
    {
        if (!empty($id)) {
            $nowStatus = $this->where('gID=' . $id)->getField('gStatus');
            if ($nowStatus == 1) {
                return $this->where('gID=' . $id)->setField('gStatus', '2');
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商品ID取消置顶架对应商品
     * @param int $id 商品ID
     * @return bool
     */
    public function goodsRankDown($id)
    {
        if (!empty($id)) {
            $nowStatus = $this->where('gID=' . $id)->getField('gStatus');
            if ($nowStatus == 2) {
                return $this->where('gID=' . $id)->setField('gStatus', '1');
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}