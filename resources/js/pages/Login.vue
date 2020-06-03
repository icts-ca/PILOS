<script>
    export default {
        name: "login-vuew",
        props: ['ldap_route','success_route'],

        data() {
            return {
                form: {
                    ldap: {
                        username: '',
                        password: '',
                    },
                    checked: []
                },
                show: true,
                loading: false,
                errors: {
                    username: null,
                    password: null,
                },

            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                this.loading = true;

                //alert(JSON.stringify(this.form))

                axios.post(this.ldap_route,{ username: this.form.ldap.username, password: this.form.ldap.password })
                    .then(response => { window.location.replace(this.success_route);})
                    .catch(error => {this.loading = false; this.errors = error.response.data.errors});

            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>
