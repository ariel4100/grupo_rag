// initial state
const state = () => ({
    carrito: localStorage.getItem('carrito_intertrade') ? JSON.parse(localStorage.getItem('carrito_intertrade')) : [],

})

// getters
const getters = {
    getPreguntas(state) {
        return state.preguntas;
    },
}

// actions
const actions = {
    addToCart ({ state, commit }, producto) {
        //Verifico si tiene cantidad
        if(parseInt(producto.cantidad) <= 0){
            alertify.warning('Agregue algun producto');
            return false
        }


        //Verifico que en el carrito no registre el mismo producto
        let producto_existe = state.carrito.some(function(cart){
            return cart.id == producto.id
        });
        //Si el producto esta en el carrito actualizo solamente la cantidad
        if (producto_existe)
        {
            let cart_actualizado = state.carrito.map(function(value) {
                if (value.id == producto.id){
                    value.cantidad = producto.cantidad
                }
                return value;
            });
            localStorage.setItem('carrito_intertrade',JSON.stringify(cart_actualizado));
        }
        //Agrega el producto si no esta en el carrito
        if(state.carrito.length == 0 || producto_existe == false){
            state.carrito.push(producto);
            localStorage.setItem('carrito_intertrade',JSON.stringify(state.carrito));

            alertify.success('Se agrego a tu carrito',producto.producto);
        }
    },
    updateItemCart ({ state, commit }, producto) {
        //Verifico si tiene cantidad
        if(parseInt(producto.cantidad) <= 0){
            alertify.warning('Agregue algun producto');
            return false
        }


        //Verifico que en el carrito no registre el mismo producto
        let producto_existe = state.carrito.some(function(cart){
            return cart.id == producto.id
        });
        //Si el producto esta en el carrito actualizo solamente la cantidad
        if (producto_existe)
        {
            let cart_actualizado = state.carrito.map(function(value) {
                if (value.id == producto.id){
                    value.cantidad = producto.cantidad
                }
                return value;
            });
            localStorage.setItem('carrito_intertrade',JSON.stringify(cart_actualizado));
        }
        //Agrega el producto si no esta en el carrito
        if(state.carrito.length == 0 || producto_existe == false){
            state.carrito.push(producto);
            localStorage.setItem('carrito_intertrade',JSON.stringify(state.carrito));

            alertify.success('Se agrego a tu carrito',producto.producto);
        }
    },


    elimItemCart({state, commit },data){
        console.log([data,state.carrito])
        if(state.carrito.length == 1){
            state.carrito = []
            localStorage.setItem('carrito_intertrade',JSON.stringify(state.carrito));
            return false
        }
        state.carrito.splice(data,1);
        localStorage.setItem('carrito_intertrade',JSON.stringify(state.carrito));

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