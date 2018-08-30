<div id="liveticker" data-graphql="{$BaseHref}graphql-liveticker" data-pageid="$ID">
    <div class="liveticker-content">

    </div>
    <span class="liveticker-load-older">
        Laad oudere berichten
    </span>
    <div class="liveticker-loader">
        Loading...
    </div>
    <script type="text/x-tmpl" id="liveticker-template">
        <div class="liveticker-message">
            <div>{%=o.ID%} {%=o.Created%}</div>
            {% if (o.Title) { %}
                <strong>{%=o.Title%}</strong>
            {% } %}
            {% if (o.Message) { %}
                <p>{%=o.Message%}</p>
            {% } %}
        </div>
    </script>
</div>

<style>
    #liveticker {
        max-height: 500px;
        overflow: auto;
    }
    .liveticker-content .liveticker-message {
        border-bottom: 1px solid black;
        margin-bottom: 20px;
        padding-bottom: 20px;
        transition: background-color 0.5s ease;
    }
    .liveticker-content .liveticker-message p {
        margin-bottom: 0;
    }
    .liveticker-content .liveticker-message.is-new {
        background: red;
    }
    .liveticker-load-older {
        display: block;
        width: 150px;
        text-align: center;
        margin: 0 auto;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        background: #CCC;
    }
    .liveticker-load-older:hover {
        background: #666;
    }
</style>
