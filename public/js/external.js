let d = {}
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function externalBaseSuccessCallback(event){
    window.evn = event
    console.log('externalBaseSuccessCallback', event)

    switch(evn.target.dataset.form){
        case "login-to-account":
            login(event)
            break;
        case "user-registration":
            registration(event)
            break;
        case "sms-code":
            senCode(event)
            break;
        case "edit-account":
            editAccount(event)
            break;
        case "feedback":
            addFeedback(event)
            break;
    }

}
function externalBaseErrorCallback(event){
    console.log('externalBaseErrorCallback', event)
}

function login(event){
    const data = {
        phone: event.target.elements['phone-login'].value,
        password: event.target.elements['password-login'].value,
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data)
    };

    fetch('/login', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            location.reload();
            console.log('Успешная авторизация:', data);
        })
        .catch(error => {
            console.log('Произошла ошибка:', error);
        });
}

function registration(event){
    d.phone = event.target.elements['phone-registration'].value
    const data = {
        name: event.target.elements['name-registration'].value,
        phone: event.target.elements['phone-registration'].value,
        password: event.target.elements['password-registration'].value,
        password2: event.target.elements['password-registration'].value,
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data)
    };

    fetch('/registration', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('response', data);
            if(data.code == 200){
                modals.close('user-registration')
                setTimeout(()=>{
                    modals.open('sms-code')
                    bindCodeForm()
                },500)
            }
            if(data.code == 202){
                modals.close('user-registration')
                setTimeout(()=>{
                    modals.open('user-success')
                },500)
            }

        })
        .catch(error => {
            console.log('Произошла ошибка:', error);
        });
}

function senCode(event){
    let cd = event.target.elements['code-sms-1'].value +
             event.target.elements['code-sms-2'].value +
             event.target.elements['code-sms-3'].value +
             event.target.elements['code-sms-4'].value
    const data = {
        code: cd,
        phone: d.phone,
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data)
    };

    fetch('/send-code', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('response', data);
            if(data.code == 200){
                unbindCodeForm()
                modals.close('sms-code')
                setTimeout(()=>{
                    modals.open('user-success')
                },500)
            }
        })
        .catch(error => {
            console.log('Произошла ошибка:', error);
        });
}

function editAccount(event){
    let formData = new FormData();

    let fileInput = document.querySelector('.avatar #files-image');
    let fileText = document.querySelector('.avatar #files-image-help');
    let file = fileInput.files[0];
    if (file) {
        formData.append('file', file);
    }
    formData.append('fileText', fileText.value);
    formData.append('phone', event.target.elements['phone'].value);
    formData.append('name', event.target.elements['name'].value);
    formData.append('email', event.target.elements['email'].value);

    formData.append('oldPassword', event.target.elements['old-password'].value);
    formData.append('newPassword', event.target.elements['new-password'].value);
    formData.append('repeatPassword', event.target.elements['repeat-password'].value);

    formData.append('emailDelivery', event.target.elements['email-delivery'].checked);
    formData.append('smsDelivery', event.target.elements['sms-delivery'].checked);
    const options = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData
    };

    fetch('/update-account', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('response', data);
            if(data.code == 200){
                unbindCodeForm()
                modals.close('sms-code')
            }
        })
        .catch(error => {
            console.log('Произошла ошибка:', error);
        });
}

function bindCodeForm(){
    const smsInputs = document.querySelectorAll('[data-modal="sms-code"] input');
    smsInputs.forEach(input => {
        input.addEventListener('input', handleInputSubmit)
    })
}
function unbindCodeForm(){
    const smsInputs = document.querySelectorAll('[data-modal="sms-code"] input');
    smsInputs.forEach(input => {
        input.removeEventListener('input', handleInputSubmit);
    })
}
function handleInputSubmit() {
    document.querySelector('[data-modal="sms-code"] #sms-code-send').click();
}

function favorite(table, id, element = false) {
    table = table?.id || table
    let csrf = document.querySelector('meta[name="csrf-token"]').content;
    axios.post(`/news/favorite/${table}/${id}`, {
        headers: {
            'X-CSRF-Token': csrf
        }
    }).then(res => {
        return
        if (res.data) {
            if(element){
                element.classList.add('is-favorite')
            } else {
                document.querySelectorAll('.article__actions').forEach(e => {
                    e.classList.add('is-favorite')
                })
            }
        } else {
            if(element){
                element.classList.remove('is-favorite')
            } else {
                document.querySelectorAll('.article__actions').forEach(e => {
                    e.classList.remove('is-favorite')
                })
            }

        }
    })
}

function addFeedback(event){
    const data = {
        name: event.target.elements['feed-name'].value,
        email: event.target.elements['feed-email'].value,
        message: event.target.elements['feed-message'].value,
    };
    const options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(data)
    };

    fetch('/addfeedback', options)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.status == 200){
                modals.close('feedback')
            }
        })
        .catch(error => {
            console.log('Произошла ошибка:', error);
        });
}

function deleteComment(element){
    let commentId = element.getAttribute('comment-id')
    let csrf = document.querySelector('meta[name="csrf-token"]').content;
    axios.post(`/admin/comments/web-delete/${commentId}`, {
        headers: {
            'X-CSRF-Token': csrf
        }
    })
    .then(res => {
        if (res.data) {
            element.remove()
        } else {


        }
    })
}
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('admin-trash-comment')) {
        const commentId = event.target.getAttribute('comment-id');
        const userConfirmed = confirm('Вы уверены, что хотите удалить этот комментарий?');
        if (userConfirmed) {
            deleteComment(document.querySelector(`[element][comment-id="${commentId}"]`))
        }
    }
});
