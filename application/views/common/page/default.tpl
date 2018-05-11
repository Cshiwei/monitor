<nav aria-label="Page navigation">
    <ul class="pagination">
        <{if $linkArr.firstLink}>
            <li>
                <a href="<{$linkArr.firstLink}>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <{/if}>

        <{if $linkArr.commonLink}>
            <{foreach $linkArr.commonLink as $key=>$val }>
                <li><a href="<{$val}>" > <{$key}> </a></li>
            <{/foreach}>
        <{/if}>

        <{if $linkArr.lastLink}>
            <li>
                <a href="<{$linkArr.lastLink}>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <{/if}>
    </ul>
</nav>