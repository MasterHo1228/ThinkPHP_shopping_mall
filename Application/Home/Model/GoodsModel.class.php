<?php
/**
 * Created by PhpStorm.
 * User: MasterHo
 * Date: 2016/12/11
 * Time: 20:23
 */

namespace Home\Model;

class GoodsModel
{
    public function getIndexList()
    {
        $table = M('viewgoodsdetail');
        $where = "gStatus<>'0'";
        return $table->where($where)->order('gStatus DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->limit(30)->select();
    }

    public function getLatestList()
    {
        $table = M('viewgoodsdetail');
        $where = "gStatus<>'0'";
        return $table->where($where)->order('gPubTime DESC')->field('gID,gName,gPrice,gPhoto,gStatus')->limit(30)->select();
    }

    public function getTop3Goods()
    {
        $table = M('viewgoodsdetail');
        $data = $table->where("gStatus='2'")->field('gID,gName,gPrice,gPhoto,gDescription')->limit(3)->select();
        return $data;
    }

    public function getDetailByID($id)
    {
        if (!empty($id)) {
            $table = M('viewgoodsdetail');
            $where = 'gID=' . $id;
            $status = $table->where($where)->getField('gStatus');
            if ($status != '0') {
                return $table->where($where)->field('gID,gName,goodsTypeName,gPrice,gOriginPrice,gCount,shopName,gPhoto,gDescription,gPubTime')->find();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}