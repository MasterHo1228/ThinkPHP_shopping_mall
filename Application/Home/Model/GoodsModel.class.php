<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016/12/11
 * Time: 20:23
 */

namespace Home\Model;

/**
 * 前台商品模型类
 * Class GoodsModel
 * @package Home\Model
 */
class GoodsModel
{
    /**
     * 生产首页商品列表
     * @return mixed
     */
    public function getIndexList()
    {
        $table = M('viewgoodsdetail');
        $where = "gStatus<>'0'";
        return $table->cache(true)->where($where)->order('gStatus DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->limit(30)->select();
    }

    /**
     * 获取最新上架的商品
     * @return mixed
     */
    public function getLatestList()
    {
        $table = M('viewgoodsdetail');
        $where = "gStatus<>'0'";
        return $table->cache(true)->where($where)->order('gPubTime DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->limit(30)->select();
    }

    /**
     * 获取近期推荐的前3名商品
     * @return mixed
     */
    public function getTop3Goods()
    {
        $table = M('viewgoodsdetail');
        $data = $table->cache(true)->where("gStatus='2'")->field('gID,gName,gPrice,gPhoto,gDescription')->limit(3)->select();
        return $data;
    }

    /**
     * 根据商品ID获取商品详细信息
     * @param int $id 商品ID
     * @return bool|mixed
     */
    public function getDetailByID($id)
    {
        if (!empty($id)) {
            $table = M('viewgoodsdetail');
            $where = 'gID=' . $id;
            $status = $table->where($where)->getField('gStatus');
            if ($status != '0') {//若商品非已下架 则照常返回数据
                return $table->cache(true)->where($where)->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gSoldOutNum,gCount,shopName,gPhoto,gDescription,gPubTime')->find();
            } else {
                //商品若已下架 则直接false
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 根据商品种类生成商品列表
     * @param int $type 商品种类编号
     * @return bool
     */
    public function getListByGoodsType($type)
    {
        if (!empty($type)) {
            $table = M('viewgoodsdetail');
            $where = "gType='$type' AND gStatus<>'0'";

            return $table->where($where)->order('gStatus DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->select();
        } else {
            return false;
        }
    }

    /**
     * 根据前台搜索的关键字查找商品
     * @param string $key 关键字
     * @return bool
     */
    public function getListBySearchKey($key)
    {
        if (!empty($key)) {
            $table = M('viewgoodsdetail');
            $where = "gName LIKE '%" . $key . "%'";

            return $table->where($where)->order('gStatus DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->select();
        } else {
            return false;
        }
    }
}