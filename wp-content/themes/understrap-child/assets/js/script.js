jQuery(document).ready(function($) {
    $('.galleryItems').lightGallery({
        selector: 'a',
        counter: false
    });
});

document.addEventListener("DOMContentLoaded", function() {
  var entryContentDivs = document.querySelectorAll('.card-city');

  entryContentDivs.forEach(function(entryContentDiv) {
    var paragraphs = entryContentDiv.querySelectorAll('p');
    
    if (paragraphs.length > 0) {
      var firstParagraph = paragraphs[0];
      var originalText = firstParagraph.textContent;
      var maxLength = 20; 
      var words = originalText.split(' ');
      var truncatedText = words.slice(0, maxLength).join(' ');

      if (words.length > maxLength) {
        truncatedText += '...';
      }

      firstParagraph.textContent = truncatedText;
    }
  });
});