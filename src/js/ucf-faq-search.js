$(document).ready(() => {
  const empty      = UCF_FAQ_SEARCH.empty ? Handlebars.compile(UCF_FAQ_SEARCH.empty) : null;
  const suggestion = UCF_FAQ_SEARCH.suggestion ? Handlebars.compile(UCF_FAQ_SEARCH.suggestion) : null;
  const footer     = UCF_FAQ_SEARCH.footer ? Handlebars.compile(UCF_FAQ_SEARCH.footer) : null;
  const limit      = UCF_FAQ_SEARCH.limit || 5;

  const decodeHTMLEntities = (encodedString) => {
    const textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
  };

  const engine = new Bloodhound({
    remote: {
      url: `${UCF_FAQ_SEARCH.remote_path}?search=%q&orderby=relevance&per_page=${limit}`,
      wildcard: '%q'
    },
    queryTokenizer: (q) => {
      return Bloodhound.tokenizers.whitespace(q);
    },
    datumTokenizer: (datum) => {
      return Bloodhound.tokenizers.whitespace(datum.title.rendered);
    }
  });

  $('.faq-typeahead').typeahead({
    minLength: 3,
    highlight: true
  },
  {
    name: 'faq-search',
    limit: limit,
    display: (faq) => {
      return decodeHTMLEntities(faq.title.rendered);
    },
    source: engine.ttAdapter(),
    templates: {
      notFound: empty,
      suggestion: suggestion,
      footer: footer
    }
  }).on('typeahead:selected', (e, o) => {
    window.location = o.link;
  });
});
