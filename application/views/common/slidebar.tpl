<div class="col-xs-2">
    <ul class="nav nav-pills nav-stacked">
        <{foreach $slidebarLink as $val}>
            <li role="presentation" class="<{if $active eq $val.val}>active<{/if}>"><a href="<{$val.link}>"><{$val.name}></a></li>
        <{/foreach}>
    </ul>
</div>