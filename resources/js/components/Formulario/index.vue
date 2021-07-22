<template>
    <div>
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Ingrese sus datos</h2>
                    </div>
                    <div class="card-body">
                        <form id="form1" @submit.prevent="guardar">
                            <div class="form-group">
                                <label for="nombre">Nombres completos</label>
                                <input
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.nombre.$error
                                    }"
                                    class="form-control"
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Ingrese su nombre completo"
                                    v-model="$v.formulario.nombre.$model"
                                />
                                <div
                                    v-if="submitted && $v.formulario.nombre"
                                    class="invalid-feedback"
                                >
                                    Nombres es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.email.$error
                                    }"
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="Email"
                                    v-model="$v.formulario.email.$model"
                                />
                                <div
                                    v-if="
                                        submitted && $v.formulario.email.$error
                                    "
                                    class="invalid-feedback"
                                >
                                    <span v-if="!$v.formulario.email.required"
                                        >Email is required</span
                                    >
                                    <span v-if="!$v.formulario.email.email"
                                        >Email is invalid</span
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rut">Rut</label>
                                <input
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.rut.$error
                                    }"
                                    class="form-control"
                                    type="text"
                                    id="rut"
                                    name="rut"
                                    placeholder="Ingrese su rut"
                                    v-model="$v.formulario.rut.$model"
                                />
                                <div
                                    v-if="submitted && $v.formulario.rut"
                                    class="invalid-feedback"
                                >
                                    Rut es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fecha_nacimiento"
                                    >Fecha de nacimiento</label
                                >
                                <input
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.fecha_nacimiento
                                                .$error
                                    }"
                                    class="form-control"
                                    type="date"
                                    id="fecha_nacimiento"
                                    name="fecha_nacimiento"
                                    v-model="
                                        $v.formulario.fecha_nacimiento.$model
                                    "
                                />
                                <div
                                    v-if="
                                        submitted &&
                                            $v.formulario.fecha_nacimiento
                                    "
                                    class="invalid-feedback"
                                >
                                    Fecha de nacimiento es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="region">region</label>
                                <select
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.region.$error
                                    }"
                                    class="form-control"
                                    type="text"
                                    id="region"
                                    name="region"
                                    placeholder="Ingrese su nombre completo"
                                    v-model="$v.formulario.region.$model"
                                    @change="getProvincias(formulario.region)"
                                >
                                    <option
                                        v-for="(region, key) in regiones"
                                        :key="key"
                                        :value="region.id"
                                        >{{ region.region }}</option
                                    >
                                </select>
                                <div
                                    v-if="submitted && $v.formulario.region"
                                    class="invalid-feedback"
                                >
                                    Region es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="provincia">Provincia</label>
                                <select
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.provincia.$error
                                    }"
                                    class="form-control"
                                    type="text"
                                    id="provincia"
                                    name="provincia"
                                    placeholder="Ingrese su nombre completo"
                                    v-model="$v.formulario.provincia.$model"
                                    @change="getComunas(formulario.provincia)"
                                >
                                    <option
                                        v-for="(provincia, key) in provincias"
                                        :key="key"
                                        :value="provincia.id"
                                        >{{ provincia.provincia }}</option
                                    >
                                </select>
                                <div
                                    v-if="submitted && $v.formulario.provincia"
                                    class="invalid-feedback"
                                >
                                    Provincia es requerido
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="comuna">Comuna</label>
                                <select
                                    :class="{
                                        'is-invalid':
                                            submitted &&
                                            $v.formulario.comuna.$error
                                    }"
                                    class="form-control"
                                    type="text"
                                    id="comuna"
                                    name="comuna"
                                    placeholder="Ingrese su nombre completo"
                                    v-model="$v.formulario.comuna.$model"
                                >
                                    <option
                                        v-for="(comuna, key) in comunas"
                                        :key="key"
                                        :value="comuna.id"
                                        >{{ comuna.comuna }}</option
                                    >
                                </select>
                                <div
                                    v-if="submitted && $v.formulario.comuna"
                                    class="invalid-feedback"
                                >
                                    Comuna es requerido
                                </div>
                            </div>
                            <div
                                v-if="status >= 0"
                                class="alert "
                                role="alert"
                                :class="
                                    status == 0
                                        ? 'alert-danger'
                                        : 'alert-success'
                                "
                            >
                                {{ mensaje }}
                            </div>
                            <button class="btn btn-success ">
                                Guardar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";
export default {
    data() {
        return {
            formulario: {
                nombre: "",
                email: "",
                rut: "",
                fecha_nacimiento: "",
                region: "",
                provincia: "",
                comuna: ""
            },
            mensaje: "",
            status: -1,
            submitted: false,
            regiones: [],
            provincias: [],
            comunas: []
        };
    },
    validations: {
        formulario: {
            nombre: { required },
            email: { required, email },
            rut: { required },
            fecha_nacimiento: { required },
            region: { required },
            provincia: { required },
            comuna: { required }
        }
    },
    methods: {
        guardar(e) {
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.status = -1;
            axios.post(`/`, this.formulario).then(res => {
                console.log("res", res);
                this.status = res.data.status;
                if (res.data.status == 1) {
                    this.mensaje = res.data.mensaje;
                    this.limpiarForm();
                } else if (res.data.status == 0) {
                    this.mensaje = res.data.mensaje;
                }
            });
        },
        limpiarForm() {
            this.formulario = {
                nombre: "",
                email: "",
                rut: "",
                fecha_nacimiento: "",
                region: "",
                comuna: ""
            };
        },
        getRegiones() {
            axios.get(`/api/regiones`).then(res => {
                this.regiones = res.data;
            });
            console.log("this.regiones", this.regiones);
        },
        getProvincias(region) {
            console.log("region", region);
            axios.get(`/api/provincias/${region}`).then(res => {
                this.provincias = res.data;
            });
        },
        getComunas(provincia) {
            axios.get(`/api/comunas/${provincia}`).then(res => {
                this.comunas = res.data;
            });
        }
    },
    created() {
        this.getRegiones();
    }
};
</script>

<style module lang="scss"></style>
