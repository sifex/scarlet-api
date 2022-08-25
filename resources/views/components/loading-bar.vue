<template>
    <div class="progress-wrapper">
        <div class="progress" role="progressbar" tabindex="0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <canvas :class="{
                'bg-sky-600': color === 'sky',
                'bg-emerald-600': color === 'emerald'}"
                class="progress-meter" :style="{ width: width + '%' }"></canvas>
        </div>
    </div>
</template>

<script>
export default {
    name: 'loading-bar',
    props: ['width', 'color'],
    methods: {
        updateWitdh(width) {
            this.width = width
        }
    }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.progress-wrapper {
    -webkit-user-select: none;

    &, &:focus, .progress, .progress:focus {
        outline: none;
    }

    .progress {
        width: 100%;
        height: 48px;
        background-color: #060b16;
        border-radius: 4px;
        padding: 6px;

        .progress-meter {
            //background-color: #3787d0;
            height: 100%;
            width: 0;
            transition: width 200ms;
            border-radius: 4px;

            #granim-canvas {
                height: 100%;
                width: 100%;
            }
        }
    }

    #download.complete & {
        .progress-meter {
            background-color: #8edb59;
        }
    }
}

</style>
