<template>
    <aside>
        <ul class="list-unstyled">
            <li class="list-group-item border-0 p-0" v-for="(item,key) in familias">
                <a  :data-target="'#categoria_'+key" data-toggle="collapse" aria-expanded="false" class="d-flex align-items-center p-2 border-bottom fwb700 " :class="familiaId == item.id ? 'bg-primario text-white' : 'text-secundario'">
<!--                    <span onclick="location.href='{{ route('producto.subfamilias',$item->slug) }}'"></span>-->
                    {{ item.title }}

                    <i class="fas fa-plus ml-auto" style="font-size: 8px"></i>
                </a>
                <ul class="list-unstyled collapse " :class="familiaId == item.id ? 'show ' : ''" style="background-color: #F8F8F8" :id="'categoria_'+key">
                    <li class="pt-3 border-bottom pl-3 pr-2" :style="productoId == producto .id ? 'background-color:#DBDBDB;' : 'text-secundario'" v-for="producto in item.productos"><a :href="producto.ruta" class="text-secundario ">{{ producto.title }} </a></li>
                </ul>
            </li>
        </ul>
    </aside>
</template>

<script>
    import Login from '@/Components/LoginComponent'
    export default {
        components: {
          'login-component': Login
        },
        props:['familias','familiaId','productoId'],
        data() {
            return {

            }
        },
        methods: {

        }
    }
</script>