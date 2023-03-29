<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
  <script>
tinymce.init({
      selector: 'textarea',  // Le sélecteur CSS de votre zone de texte
      height: 300,  // La hauteur de l'éditeur
      plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table paste code help wordcount'
],
      toolbar: 'undo redo | formatselect | bold italic backcolor | \
                alignleft aligncenter alignright alignjustify | \
                bullist numlist outdent indent | removeformat | help'
    });
  </script>
</head>
<body>
  <textarea>Entrez votre texte ici</textarea>
</body>
</html>