<template>
    <div class="container">
        <div class="row mt-4">
            <div class="col-6 offset-3">
              <b-card no-body bg-variant="light">
                <b-tabs content-class="m-3" align="center" fill active-nav-item-class="bg-success text-white">
                  <b-tab :title="$t('auth.ldap.tabTitle')" active>
                    <ldap-login-component
                      id="ldap"
                      :title="$t('auth.ldap.title')"
                      @submit="handleLogin"
                      :submit-label="$t('auth.login')"
                      :password-label="$t('auth.password')"
                      :username-label="$t('auth.ldap.username')"
                      :loading="loading"
                      :errors="errors.ldap"
                    ></ldap-login-component>
                  </b-tab>
                  <b-tab :title="$t('auth.email.tabTitle')">
                    <email-login-component
                      id="default"
                      :title="$t('auth.email.title')"
                      @submit="handleLogin"
                      :submit-label="$t('auth.login')"
                      :password-label="$t('auth.password')"
                      :email-label="$t('auth.email.email')"
                      :loading="loading"
                      :errors="errors.default"
                    ></email-login-component>
                  </b-tab>
                </b-tabs>
              </b-card>
            </div>
        </div>
    </div>
</template>

<script>
import EmailLoginComponent from './EmailLoginComponent';
import LdapLoginComponent from './LdapLoginComponent';

export default {
  components: {
    EmailLoginComponent,
    LdapLoginComponent
  },
  data () {
    return {
      loading: false,
      errors: {
        default: null,
        ldap: null
      }
    };
  },
  methods: {
    async handleLogin ({ data, id }) {
      try {
        this.errors[id] = null;
        this.loading = true;
        await this.$store.dispatch('session/login', { credentials: data, method: id });
        this.flashMessage.success(this.$t('auth.flash.login'));
        await this.$router.push({ name: 'rooms.index' });
      } catch (error) {
        if (error.response !== undefined && error.response.status === 422) {
          this.errors[id] = error.response.data.errors;
        } else {
          this.loading = false;
          throw error;
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>

</style>
