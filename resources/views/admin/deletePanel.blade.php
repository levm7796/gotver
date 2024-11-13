<style>
    .overlay-panel {
        display:none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }
    .panel-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-align: center;
    }
    .custom-box {
        color: black;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
</style>

<div id="panel" class="overlay-panel">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-4 panel-content">
            <div class="custom-box">
                <h3>Вы уверены что хотите удалить?</h3>
                <p class="m-4"></p>
                <div class="">
                    <button class="btn btn-outline-primary">Отмена</button>
                    <a href="#" class="btn btn-outline-danger">Удалить</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let showPanelBtns, panel, el_p, cancelBtn, deleteBtn
    panel = document.querySelector('#panel');
    el_p =  panel.querySelector('p');
    cancelBtn = panel.querySelector('.btn-outline-primary');
    deleteBtn = panel.querySelector('.btn-outline-danger');
    // setTimeout(()=>{
    //     showPanelBtns= document.querySelectorAll('[delete-btn]');
    //     console.log(showPanelBtns)
    //     el_p =  panel.querySelector('p');
    //     
    //     

    //     showPanelBtns.forEach(btn=>{
    //         console.log(btn)
    //         btn.addEventListener('click', handleButtonClick);
    //     })

    //     cancelBtn.addEventListener('click', function() {
    //         panel.style.opacity = '0';
    //         setTimeout(function() {
    //             panel.style.display = 'none';
    //         }, 300);
    //     });
    // },1000)
    document.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('click', function(event) {
            const target = event.target;

            // Проверяем, если клик был на элементе с атрибутом [delete-btn]
            if (target.hasAttribute('delete-btn')) {
                handleButtonClick(event);
            }

            // Проверяем, если клик был на элементе с классом '.btn-outline-primary'
            if (target.classList.contains('btn-outline-primary')) {
                const panel = document.querySelector('#panel');
                if (panel) {
                    panel.style.opacity = '0';
                    setTimeout(function() {
                        panel.style.display = 'none';
                    }, 300);
                }
            }

            
        });
    });

    function handleButtonClick(event) {
        console.log('click', event.target)
        let hreff = event.target.getAttribute('hreff');
        let p = event.target.getAttribute('pp');
        console.log(hreff)
        console.log(p)
        console.log(el_p)
        el_p.innerHTML = p
        deleteBtn.href = hreff
        panel.style.display = 'block';
        setTimeout(function() {
            panel.style.opacity = '1';
        }, 0);
    }


</script>
