// initial state
const state = () => ({
    preguntas: [],
    ayuda: {
        text: '',
        key: '',
    },
    profesion: {
        text: '',
    },
    sector: {
        text: '',
    },
    familia: {
        text: '',
    },
    loading: false,
    loaded: 1,
    route: '',

})

// getters
const getters = {
    getPreguntas(state) {
        return state.preguntas;
    },
}

// actions
const actions = {
    getData ({ state, commit }) {
        state.loading = true

        axios.get(route('vendedor.api.help').url()).then(({ data }) => {
            console.log(data)
            state.preguntas = data.item
            state.loading = false
        }).catch(e => {
            alertify.error('Algo salio mal. error: '+ e)
        });
    },


    eliminar({state, commit },data){
        console.log(data)
        console.log(inertia)
        Swal.fire({
            title: '¿Estas seguro de eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value) {
                inertia.delete(data).then(() => {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Se elimino correctamente',
                    //     showConfirmButton: false,
                    //     timer: 2000
                    // })
                    $('.modal').modal('hide');
                })
            }
        })
    },

    solicitarProfesion({state, commit }){
        state.loaded = 0
        if (state.profesion.text == '') {
            state.loaded = 1
            return false
        }

        axios.post(route('sendconsulta', state.profesion).url()).then( res => {
            console.log(res)
            state.profesion.text = ''
            commit('MAIL_SUCCESS',res.data)

        }).catch(e => {
            Swal.fire({
                icon: 'error',
                title: 'Se encontraron los siguientes errores',
                html:  e,
                showConfirmButton: false,
            })
            state.loaded = 1

        })

    },

    solicitarRubro({state, commit }){
        state.loaded = 0
        if (state.sector.text == '') {
            state.loaded = 1
            return false
        }

        axios.post(route('sendconsulta', state.sector).url()).then( res => {
            console.log(res)
            state.sector.text = ''
            commit('MAIL_SUCCESS',res.data)

        }).catch(e => {
            Swal.fire({
                icon: 'error',
                title: 'Se encontraron los siguientes errores',
                html:  e,
                showConfirmButton: false,
            })
            state.loaded = 1

        })

    },

    solicitarFamilia({state, commit }){
        state.loaded = 0
        if (state.familia.text == '') {
            state.loaded = 1
            return false
        }

        axios.post(route('sendconsulta', state.familia).url()).then( res => {
            console.log(res)
            state.familia.text = ''
            commit('MAIL_SUCCESS',res.data)

        }).catch(e => {
            Swal.fire({
                icon: 'error',
                title: 'Se encontraron los siguientes errores',
                html:  e,
                showConfirmButton: false,
            })
            state.loaded = 1

        })

    },
}

// mutations
const mutations = {

    SET_PUBLICACIONES_LIST_STATUS_SUCCESS(state, productos) {
        state.publicaciones = productos;
    },
    MAIL_SUCCESS(state, item) {
        if(item.status == 'error'){
            // console.log('entra aca')
            Swal.fire({
                icon: 'error',
                title: 'Se encontraron los siguientes errores',
                html:  item.errors[0],
                showConfirmButton: false,
            })
            state.loaded = 1

        }else{
            Swal.fire({
                icon: 'success',
                title: 'Se envió correctamente',
                showConfirmButton: false,
                timer: 1500
            })
            state.loaded = 1
            $('.modal').modal('hide')
            //
            // window.location.reload()
        }
    },




}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}