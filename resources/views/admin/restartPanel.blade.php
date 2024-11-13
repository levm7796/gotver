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

<div id="panel1" class="overlay-panel">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-4 panel-content">
            <div class="custom-box">
                <h3>Вы уверены что хотите обновить?</h3>
                <p class="m-4"></p>
                <div class="">
                    <button class="btn btn-outline-primary">Отмена</button>
                    <a href="#" class="btn btn-outline-danger">Обновить</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let showPanelBtns1, panel1, el_p1, cancelBtn1, restartBtn1
    setTimeout(()=>{
        showPanelBtns1= document.querySelectorAll('[restart-btn]');
        console.log('showPanel1',showPanelBtns1)
        panel1 = document.querySelector('#panel1');
        el_p1 =  panel1.querySelector('p');
        cancelBtn1 = panel1.querySelector('.btn-outline-primary');
        restartBtn1 = panel1.querySelector('.btn-outline-danger');

        showPanelBtns1.forEach(btn=>{
            console.log('restart', btn)
            btn.addEventListener('click', handleButtonClick1);
        })

        cancelBtn1.addEventListener('click', function() {
            panel1.style.opacity = '0';
            setTimeout(function() {
                panel1.style.display = 'none';
            }, 300);
        });
    },1000)
    function handleButtonClick1(event) {
        console.log('click', 'restart', event.target)
        let hreff = event.target.getAttribute('hreff');
        let p = event.target.getAttribute('pp');
        console.log(hreff)
        el_p1.innerHTML = p
        restartBtn1.href = hreff
        panel1.style.display = 'block';
        setTimeout(function() {
            panel1.style.opacity = '1';
        }, 10);
    }


</script>
