function insertParam(key, value) {
    key = encodeURIComponent(key);
    value = encodeURIComponent(value);

    var kvp = document.location.search.substr(1).split('&');
    let i=0;

    for(; i<kvp.length; i++){
        if (kvp[i].startsWith(key + '=')) {
            let pair = kvp[i].split('=');
            pair[1] = value;
            kvp[i] = pair.join('=');
            break;
        }
    }

    if(i >= kvp.length){
        kvp[kvp.length] = [key,value].join('=');
    }

    let params = kvp.join('&');

    document.location.search = params;
}

function sort() {
    $sort_type = document.getElementById('sortSelect').value;

    insertParam('sort', $sort_type);
}

function prev() {
    var urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.get('pg_num')) {
        insertParam('pg_num', 1);    
    } else {
        insertParam('pg_num', urlParams.get('pg_num') - 1);
    }
}

function next() {
    var urlParams = new URLSearchParams(window.location.search);
    if (!urlParams.get('pg_num')) {
        insertParam('pg_num', Number(urlParams.get('pg_num')) + 2);
    } else {
        insertParam('pg_num', Number(urlParams.get('pg_num')) + 1);
    }
}