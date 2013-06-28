

<style>

    table.search-results tr {
        border-top: 1px solid #ddd;
    }

    table.search-results tr td {
        padding: 15px 0;
    }

    td.search-result-thumb-cell {
        width: 75px;
        padding-right: 15px;
    }

    td.search-result-thumb-cell img {
        width: 60px;
    }

</style>


<h1>Search</h1>


<?php //echo "<pre>".print_r($data['results'], true)."</pre>"; ?>



<div class="gsc-result-info" id="resInfo-0">
    About <?php echo $data['results']->cursor->estimatedResultCount; ?> results
    (<?php echo $data['results']->cursor->searchResultTime; ?> seconds)
</div>

<table class="search-results">
    <?php if(!empty($data['results']->results)): ?>
    <?php foreach($data['results']->results as $result): ?>
        <tr>
            <?php $thumb_exists = (!empty($result->richSnippet->cseThumbnail->src)) ? true : false; ?>
            <?php if($thumb_exists): ?>
                <td class="search-result-thumb-cell">
                    <a class="gs-title" href="<?php echo $result->url; ?>" target="_top" dir="ltr"
                       data-cturl="<?php echo $result->clicktrackUrl; ?>"
                       data-ctorig="<?php echo $result->url; ?>">
                        <img src="<?php echo $result->richSnippet->cseThumbnail->src; ?>">
                    </a>
                </td>
            <?php endif; ?>
            <td<?php if(!$thumb_exists) echo ' colspan="2"'; ?>>
                <div>
                    <div class="gs-title gsc-table-cell-thumbnail gsc-thumbnail-left">
                        <a class="gs-title" href="<?php echo $result->url; ?>" target="_top" dir="ltr"
                           data-cturl="<?php echo $result->clicktrackUrl; ?>"
                           data-ctorig="<?php echo $result->url; ?>">
                            <?php echo $result->title; ?>
                        </a>
                    </div>
                    <div class="gs-bidi-start-align gs-snippet" dir="ltr">
                        <?php echo $result->content; ?>
                    </div>
                    <div class="gsc-url-bottom">
                        <?php echo $result->formattedUrl; ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>


<div class="" dir="ltr">
    <?php if(!empty($data['results']->cursor->pages)): ?>
        <?php foreach($data['results']->cursor->pages as $i => $pages): ?>
            <a href="/search?q=<?php echo $data['q']; ?>&start=<?php echo $pages->start; ?>"
               class="btn btn-small current-page" tabindex="<?php echo $i; ?>">
                <?php echo $pages->label; ?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



<div class="gcsc-branding">
    <table cellspacing="0" cellpadding="0" class="gcsc-branding">
        <tbody>
        <tr>
            <td class="gcsc-branding-text"><div class="gcsc-branding-text">powered by</div></td>
            <td class="gcsc-branding-img-noclear">
                <a href="http://www.google.com/cse/?hl=en" target="_BLANK" class="gcsc-branding-clickable">
                    <img src="http://www.google.com/uds/css/small-logo.png" class="gcsc-branding-img-noclear">
                </a></td><td class="gcsc-branding-text gcsc-branding-text-name">
                <div class="gcsc-branding-text gcsc-branding-text-name">Custom Search</div>
            </td>
        </tr>
        </tbody>
    </table>
</div>