<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">详情</h4>
</div>
<div class="modal-body">
    <h4><{$info.name}></h4>
    <p>阈值：<{$info.thresholdShow}></p>
    <p>描述：<{$info.desc}></p>
    <hr/>
    <p>最近数据</p>
    <div class="pre-scrollable">
        <table class="table table-condensed ">
            <tr>
                <td></td>
                <td>序号</td>
                <td>值</td>
                <td>时间</td>
            </tr>
            <tbody>
            <{foreach $list as $val}>
                <tr class="<{$val.scene}>">
                    <td></td>
                    <td><{$val@iteration}></td>
                    <td><{$val.thresholdShow}></td>
                    <td><{$val.normTimeShow}></td>
                </tr>
            <{/foreach}>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
    <a href="/norm/normDetail?normId=<{$info.id}>" type="button" class="btn btn-primary">详情</a>
</div>