$(function() {
  fetch('https://sites.mobotics.in/my_grocer/api/products')
  .then(response => response.json())
  .then((response) => {
    $('.loader').fadeOut();
    $(response.data).each(function(i, row) {
      var priceComb = '<ul class="list-group list-group-flush">';
      $(row.combinations).each(function(k, comb) {
        priceComb += '<li class="list-group-item">Weight: <a href="#" class="card-link">'+comb.size+'</a> Price: <a href="#" class="card-link ml-0">'+comb.gold_value+'₹</a></li>';
      });
      priceComb += '</ul>';

      var card = `<div class="bg-light card" style="width: 18rem; margin: 0 auto; margin-bottom:30px;">
                    <img src="${row.image.small}" class="card-img-top" alt="${row.slug}">
                    <div class="card-body">
                      <h5 class="card-title">${row.title}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">SKU: ${row.sku}</h6>
                      ${priceComb}
                    </div>
                  </div>`;
      $('.data-record').append(card);
    });
  })
});