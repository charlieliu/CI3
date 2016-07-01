<div id="accordion">
    <div id="accordion-container">
    </div>
    <div class="dx-fieldset options">
        <div class="dx-field">
            <div id="multiple-enabled"></div>
            <div id="collapsible-enabled"></div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Animation duration</div>
            <div class="dx-field-value">
                <div id="slider"></div>
            </div>
        </div>
        <div class="dx-field">
            <div class="dx-field-label">Selected Items</div>
            <div class="dx-field-value">
                <div id="tagbox"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="title">
    <h1><%= CompanyName%></h1>
</script>

<script type="text/html" id="customer">
    <div class="accodion-item">
        <div>
            <p>
                <b><%= City%></b>
                (<span><%= State%></span>)
            </p>
            <p>
                <span><%= Zipcode%></span>
                <span><%= Address%></span>
            </p>
        </div>
        <div>
            <p>
                Phone: <b><%= Phone%></b>
            </p>
            <p>
                Fax: <b><%= Fax%></b>
            </p>
            <p>
                Website:
                <a href="<%= Website%>" target="_blank">
                    <%= Website%>
                </a>
            </p>
        </div>
    </div>
</script>