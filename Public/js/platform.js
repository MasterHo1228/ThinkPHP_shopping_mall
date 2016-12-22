/**
 * Created by Administrator on 2016/12/22.
 */

/**
 * 弹出bootstrap模态框
 * @param msg 提示信息
 * @param reloadType 指定确定按钮按下的操作
 */
function showAlertDialog(msg, reloadType) {
    $("#btnReload").prop('value', reloadType);
    $("#alertDialogMain").empty().append(msg);
    $("#alertDialog").modal('show');
}