
const showModal = (oppenButton, modalContent)=>{
    const opnBtn = document.getElementById(oppenButton),
    mdlcontainer = document.getElementById(modalContent)

    if(opnBtn && mdlcontainer){
        opnBtn.addEventListener('click',()=>{
            mdlcontainer.classList.add('show-modal')
        })
    }
}

showModal('open-modal','modal-container-open')

const hideModal = (closeModal, modalContent)=>{
    const close_modl = document.getElementById(closeModal),
    mdlContent = document.getElementById(modalContent)
    if (close_modl) {
       close_modl.addEventListener('click',()=>{
         mdlContent.classList.remove('show-modal')
       })
    }
}
hideModal('modal_close','modal-container-open')