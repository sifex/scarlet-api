<template>
    <div id="notification" v-if="show">
        <p id="message">{{ message }}</p>
        <button id="restart-button" @click="restartApp()" v-if="showRestartButton">
            Restart
        </button>
    </div>
</template>

<script>
    // import {updater, ws} from '../_updater'

    export default {
        name: "SelfUpdater",
        data () {
            return {
                message: 'A new Scarlet update is available. Downloading now...',
                show: false,
                showRestartButton: false
            }
        },
        mounted () {
            ipcRenderer.on('update_available', () => {
                ipcRenderer.removeAllListeners('update_available');
                this.show = true
            });
            ipcRenderer.on('update_downloaded', () => {
                ipcRenderer.removeAllListeners('update_downloaded');
                this.message = 'Update Downloaded. It will be installed on restart. Restart now?';
                this.show = true
                this.showRestartButton = true
            });
        },
        methods: {
            restartApp() {
                // ws.send("Updater" + "|" + "quit");
                ipcRenderer.send('restart_app');
            }
        }
    }
</script>

<style lang="scss" scoped>
    #notification {
        position: fixed;
        bottom: 10px;
        right: 40px;
        color: #3787d0;
        text-align: right;
        font-family: "Exo 2", sans-serif;
        font-size: 12px;
        text-transform: uppercase;
        width: 100%;

        button, p {
            display: inline-block;
        }

        button {
            padding: 5px 20px;
            border-radius: 4px;
            color: #7a8c9d;
            background-color: #284056;
        }
    }
</style>
