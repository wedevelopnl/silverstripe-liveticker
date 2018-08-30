function defer(method) {
  if (window.jQuery) {
    method();
  } else {
    setTimeout(function () {
      defer(method)
    }, 50);
  }
}

var query = `query ($PageID: Int!, $Category: String, $SortField: ReadLivetickerMessagesSortFieldType!, $SortDir: SortDirection!, $LastUpdate: String, $DateType: String, $Offset: Int) {
  readLivetickerMessages(PageID: $PageID, LastUpdate: $LastUpdate, Category: $Category, DateType: $DateType, offset: $Offset, sortBy: [{field: $SortField, direction: $SortDir}]) {
    edges {
      node {
        ID
        Title
        Message
        Created
        Category {
          Title
        }
      }
    }
    pageInfo {
      hasNextPage
      hasPreviousPage
      totalCount
    }
  }
}`;


defer(function () {

  var liveticker = jQuery('#liveticker');
  var content = liveticker.find('.liveticker-content');
  var loader = liveticker.find('.liveticker-loader');
  var olderBtn = liveticker.find('.liveticker-load-older').hide();
  var graph = graphql(liveticker.data('graphql'), {});
  var lastUpdate = false;
  var oldestDate = false;
  var isFirstLoad = true;
  var url = new URL(window.location.href);
  var category = url.searchParams.get('category');

  /**
   * Add messages
   * @param messages
   * @param notificate
   */
  function addMessages(messages, addOnTop, notificate){
    if(addOnTop){
      messages = messages.reverse();
    }
    for (var key in messages) {
      var message = messages[key].node;
      var $template = jQuery(tmpl('liveticker-template', message));
      if(addOnTop){
        content.prepend($template);
      }else{
        content.append($template);
      }
      $template.fadeIn();
      if(notificate){
        $template.addClass('is-new');
        setTimeout(function(target){
          target.removeClass('is-new');
        }, 500, $template)
      }
    }
  }

  /**
   * Ticker update
   */
  function doUpdate() {
    var data = {};
    data.PageID = liveticker.data('pageid');
    data.SortField = 'Created';
    data.SortDir = 'DESC';
    if (lastUpdate) {
      data.LastUpdate = lastUpdate;
    }
    if(category){
      data.Category = category;
    }
    graph(query, data).then(function (response) {
      var messages = response.readLivetickerMessages.edges;
      if (messages.length) {
        lastUpdate = messages[0].node.Created;
        addMessages(messages, true, true);
      }
      loader.hide();
      setTimeout(doUpdate, 500, true);
    }).catch(function (error) {
      console.log(error)
    });
  }

  /**
   * Load old
   */
  function loadOldMessages() {
    var data = {};
    data.PageID = liveticker.data('pageid');
    data.SortField = 'Created';
    data.SortDir = 'DESC';
    if(oldestDate){
      data.LastUpdate = oldestDate;
      data.DateType = 'LessThan';
    }
    if(category){
      data.Category = category;
    }
    graph(query, data).then(function (response) {
      var messages = response.readLivetickerMessages.edges;
      if (messages.length) {
        if(!lastUpdate){
          lastUpdate = messages[0].node.Created;
        }
        oldestDate = messages[messages.length - 1].node.Created;
        addMessages(messages, isFirstLoad ? true : false, true);
        isFirstLoad = false;
        if(response.readLivetickerMessages.pageInfo.hasNextPage){
          olderBtn.show();
        }
      }
      loader.hide();
    }).catch(function (error) {
      console.log(error)
    });
  }

  /**
   * Old messages button
   */
  olderBtn.click(function(e){
    e.preventDefault();
    olderBtn.hide();
    loadOldMessages();
  });

  loadOldMessages();
  setTimeout(doUpdate, 500, true);

});
