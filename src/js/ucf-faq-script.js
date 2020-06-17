$(document).ready(() => {
  const empty      = UCF_FAQ_SEARCH.empty ? Handlebars.compile(UCF_FAQ_SEARCH.empty) : null;
  const suggestion = UCF_FAQ_SEARCH.suggestion ? Handlebars.compile(UCF_FAQ_SEARCH.suggestion) : null;
  const footer     = UCF_FAQ_SEARCH.footer ? Handlebars.compile(UCF_FAQ_SEARCH.footer) : null;

  const engine = new Bloodhound({
    remote: {
      url: `${UCF_FAQ_SEARCH.remote_path}?search=%q`,
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
    limit: 5,
    displayKey: (faq) => {
      return $('<span>').html(faq.title.rendered).text();
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
