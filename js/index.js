let indexHash = "#" + (CONFIG.index || '').split(".")[0];

function getHash() {
  let hash = window.location.hash || indexHash;
  return hash.substr(1, hash.length);
}

function updateHash(content) {
  let hash = getHash();
  if (hash.indexOf('_') >= 0) {
    hash = hash.substr(0, hash.indexOf('_'));
  }
  window.location.hash = hash + "_" + content;
}
$(function () {
  let _header = $("#book_header");
  let _sidebar = $("#book_sidebar");
  let _content = $("#book_content");
  document.title = CONFIG.title;

  let metas = document.getElementsByTagName("meta");
  for (let index = 0; index < metas.length; index++) {
    let element = metas[index];
    if (element.name == 'keywords') {
      element.content = CONFIG.keywords;
    } else if (element.name == 'description') {
      element.content = CONFIG.description;
    }
  }

  $('.title', _header).text(CONFIG.title);
  $.get("mds/" + CONFIG.summaryMd, function (data) {
    _sidebar.html(marked(data));
    loadContent();
    $("a", _sidebar).on("click", function (event) {
      let href = $(this).attr("href");
      if (href.indexOf("http://") == -1 && href.indexOf('.md') > 0) {
        event.preventDefault();
        window.location.hash = "#" + href.split(".")[0];
      } else {
        $(this).attr("target", "_blank");
      }
    });
    window.onhashchange = function () {
      loadContent();
    }
  });


  function loadContent() {
    let hash = getHash();
    let page = hash;
    let anthor;
    if (page.indexOf('_') >= 0) {
      page = hash.substr(0, hash.indexOf('_'));
      author = hash.substr(hash.indexOf('_'));
      console.log(page, author)
    }
    $("a.selected", _sidebar).removeClass("selected");
    let nowLink = $("a[href='" + page + ".md']", _sidebar);
    nowLink.addClass("selected");

    $(_content).html("<div class='book-content-loading'><i class='book-icon-loading'></i></div>");

    $.get("mds/" + page + ".md", function (data) {
      $(_content).html(marked(data));
      if ("#" + page == CONFIG.index) {
        document.title = CONFIG.title;
      } else {
        document.title = $("h1", _content).text() + " - " + CONFIG.title;
      }

      $('h1, h2, h3, h4', _content).map(function () {
        let anthor = $('<a class="anthor">#</a>');
        let title = $(this);
        anthor.on('click', function () {
          updateHash(title.text());
        });
        title.append(anthor)
      });

      $('code', _content).map(function () {
        Prism.highlightElement(this);
      });

      if (CONFIG.openNewWindow) {
        $('a', _content).attr('target', '_blank')
      }


      if (nowLink.length) {
        let nowLinkIndex = -1;
        let as = $('a', _sidebar);
        as.each(function (index, item) {
          if (nowLink.is(item)) {
            nowLinkIndex = index;
            return;
          }
        });
        if (nowLinkIndex > -1) {
          let footer = $('<div class="book-footer"></div>');
          if (nowLinkIndex > 0) {
            let dom = $(as[nowLinkIndex - 1]);
            footer.append('<a class="book-footer-prev-link" href="#' + dom.attr('href').split(".")[0] + '"><i class="book-icon-left"></i> ' + dom.text() + '</a>');
          }
          if (nowLinkIndex < as.length - 1) {
            let dom = $(as[nowLinkIndex + 1]);
            footer.append('<a class="book-footer-next-link" href="#' + dom.attr('href').split(".")[0] + '">' + dom.text() + ' <i class="book-icon-right"></i></a>');
          }
          _content.append(footer);
        }
      }

      $(window).scrollTop(0);
    });
  }


  // backtop

  let timeout;
  let _backtop = $('.book-backtop');
  let _window = $(window);

  function showBacktop(show) {
    _backtop.css('display', show ? "block" : "none");
  }

  function scrollTopHandle(target, step) {
    timeout = setTimeout(function () {
      let scrollTop = target.scrollTop();
      if (scrollTop > step) {
        target.scrollTop(scrollTop - step);
        scrollTopHandle(target, step * 0.9);
      } else {
        target.scrollTop(0);
        timeout = null;
      }
    }, 5);
  }

  _window.on('scroll', function () {
    if ($(this).scrollTop() > 300) {
      showBacktop(true);
    } else {
      showBacktop(false);
    }
  });
  _backtop.on('click', function () {
    if (timeout) return;
    scrollTopHandle(_window, (document.body.scrollHeight - _window.height()) / 10);
  })


  // github
  if (CONFIG.github) {
    $(".book-header-github").attr('href', CONFIG.github);
  } else {
    $(".book-header-github").remove();
  }

});