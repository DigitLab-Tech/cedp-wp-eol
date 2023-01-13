const btnSync = document.getElementById('btn_sync');
const dateElement = document.getElementById('last_sync_date');

if(btnSync){
    btnSync.addEventListener('click', e => {
        fetch(e.target.dataset.ajaxUrl, {method: 'GET'})
        .then(response => response.text())
        .then(content => {
            content = JSON.parse(content);
            if(content.hasError){
                dateElement.innerHTML = content.msg;
            }
            else{
                dateElement.innerHTML = content.data.updated_at;
            }
        });
    });
}