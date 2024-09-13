document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let title = document.querySelector('input[name="title"]').value;
        let content = document.querySelector('textarea[name="content"]').value;
        let image = document.querySelector('input[name="image"]').value;

        if (title.trim() === '' || content.trim() === '' || image.trim() === '') {
            event.preventDefault();
            alert('Por favor, preencha todos os campos antes de enviar!');
        }
    });
});

function copyToClipboard(text) {
    // Cria um elemento temporário para copiar o texto
    const tempInput = document.createElement('input');
    document.body.appendChild(tempInput);
    tempInput.value = text;
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    
    // Alerta de sucesso
    alert('Link copiado para a área de transferência!');
}