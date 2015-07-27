<div class="abgne_tab">
    <ul class="tabs">
        {nav}
        <li><a href="#{content_id}" title="滑動">{content_title}</a></li>
        {/nav}
    </ul>

    <div class="tab_container">
        {content}
        <div id="{content_id}" class="tab_content col">
            <h2>{content_title}</h2>
            <p>{content_value}</p>
        </div>
        {/content}
    </div>
</div>