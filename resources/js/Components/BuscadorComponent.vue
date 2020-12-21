<template>
    <div class="" style="background-color: #F9F9F9">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-2 mb-md-0 mb-4">
                    <select name="" id="" class="form-control">
                        <option value="" selected>Marca</option>
                    </select>
                </div>
                <div class="col-md-2 mb-md-0 mb-4">
                    <select name="" id="" class="form-control">
                        <option value="" selected>Modelo</option>
                    </select>
                </div>
                <div class="col-md-2 mb-md-0 mb-4">
                    <select name="" id="" class="form-control">
                        <option value="" selected>Rubro</option>
                    </select>
                </div>
                <div class="col-md-3 mb-md-0 mb-4">
                    <input type="text" class="form-control" placeholder="Ingrese una descripción">
                </div>
                <div class="col-md-2 mb-md-0 mb-4 text-center text-md-left">
                    <a href="" class="btn btn-secundario m-0">
                        <i class="fas fa-search mr-2"></i>
                        buscar
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['title'],
        data() {
            return {

            }
        },
        methods: {

        }
    }
</script>