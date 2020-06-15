$(document).ready(() => {
  const engine = new Bloodhound({
    remote: {
      url: UCF_FAQ_SEARCH.remote_path,
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
    source: engine.ttAdapter()
  }).on('typeahead:selected', (e, o) => {
    window.location = o.link;
  });
});
