<template>
    <div>

        <b-navbar class="mainnav" toggleable="lg" type="light" variant="light">
            <b-container>
            <b-navbar-brand href="#">
                <img style="height: 2rem;" src="https://11.pilos-thm.de/logo/default/THMPilos.svg">
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item :to="{ name: 'home' }" href="#">Link</b-nav-item>
                    <b-nav-item :to="{ name: 'room',params: { id: 123 } }" href="#">Room</b-nav-item>
                    <b-nav-item href="#" disabled>Disabled</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-form>
                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                    </b-nav-form>

                    <b-nav-item-dropdown text="Lang" right>
                        <b-dropdown-item href="#">EN</b-dropdown-item>
                        <b-dropdown-item href="#">ES</b-dropdown-item>
                        <b-dropdown-item href="#">RU</b-dropdown-item>
                        <b-dropdown-item href="#">FA</b-dropdown-item>
                    </b-nav-item-dropdown>

                    <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                        <template v-slot:button-content>
                            <em>User</em>
                        </template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
            </b-container>
        </b-navbar>





        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

    .mainnav {
        border-bottom: 1px solid rgba(0,40,100,0.12);
    }

</style>
