<template>
    <div class="progress-wrapper">
        <div class="progress" role="progressbar" tabindex="0" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            <canvas :class="loadingBarClass"
                class="progress-meter" :style="{ width: width + '%' }"></canvas>
        </div>
    </div>
</template>

<script setup lang="ts">
import {computed, defineProps} from 'vue';
import ScarletDownloader, {Status as StatusValue, type Status as StatusType} from "@/scripts/downloader/downloader";

const props = defineProps<{
    downloader: ScarletDownloader,
}>();

const width = computed(() => props.downloader.state.completionPercentage);


const loadingBarClass = computed(() => {
    const colorMap = {
        [StatusValue.Ready]: 'bg-sky-500',
        [StatusValue.Initiating]: 'bg-sky-500',
        [StatusValue.Downloading]: 'bg-sky-500',
        [StatusValue.Done]: 'bg-emerald-500',
        [StatusValue.Error]: 'bg-red-500',
    };

    return [colorMap[props.downloader.state.status]] || ['bg-grey-500'];
});
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
        background-color: #050912;
        border-radius: 4px;
        padding: 6px;

        .progress-meter {
            //background-color: #3787d0;
            height: 100%;
            width: 0;
            transition: width 50ms;
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
