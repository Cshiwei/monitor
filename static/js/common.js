//通用方法
//指定元素里展示提示信息
function addAlert(obj,content,type) {
    if(!type)
        type = 'danger';

    var alertDom = '<div class="alert alert-'+type+' alert-dismissible fade in" role="alert">\n' +
        '                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
        '                      <strong>提示! </strong>'+content+'\n' +
        '           </div>';

    obj.html(alertDom);
}

//模态框代替alert框
function myAlert(msg)
{
    var alertDom = '<div class="modal fade" id="_alertModel" tabindex="-1" role="dialog">\n' +
        '  <div class="modal-dialog modal-sm" style="width:400px;" role="document">\n' +
        '    <div class="modal-content">\n' +
        '      <div class="modal-header">\n' +
        '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n' +
        '        <h4 class="modal-title">警告</h4>\n' +
        '      </div>\n' +
        '      <div class="modal-body">\n' +
        '        <p>'+ msg +'&hellip;</p>\n' +
        '      </div>\n' +
        '    </div><!-- /.modal-content -->\n' +
        '  </div><!-- /.modal-dialog -->\n' +
        '</div><!-- /.modal -->';
    $("body").append(alertDom);
    $("#_alertModel").modal('show')
    $("#_alertModel").on("hidden.bs.modal",function(){
        $("_alertModel").remove();
    })
}


