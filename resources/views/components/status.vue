<template>
	<span class="status">
		{{ title }}
		<span v-if="players && players > -1" class="playerNo">(Players : <i>{{ players }}</i>)</span>
		<span class="statusicon" :class="color"></span>
	</span>
</template>

<script>
    export default {
        name: 'status',
        props: ['title', 'players', 'color']
    };
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    @import "node_modules/foundation-sites/scss/foundation";
    @import 'node_modules/foundation-sites/scss/util/mixins';

    .status {
        display: block;
        color: #717b92;
        font-family: 'Exo 2', sans-serif;
        font-size: 12px;
        text-align: right;
        margin-bottom: 2px;

		.statusicon {
			height: 9px;
			width: 9px;
			border-radius: 100%;
			display: inline-block;
			margin-top: 1px;
			margin-left: 10px;
			transition: background .3s;
			position: relative;
			overflow: hidden;

			@keyframes slide {
				0% {transform:translateX(-400%);}
				100% {transform:translateX(100%);}
			}


			&:after {
				content:'';
				border-radius: 100px;
				top:0;
				transform: translateX(-100%);
				height: 9px;
				width: 9px;
				position: absolute;
				opacity: 0;
				background: linear-gradient(to right, rgba(255,255,255,0) 0%,rgba(255,255,255,0.9) 50%,rgba(128,186,232,0) 99%,rgba(125,185,232,0) 100%); /* W3C */
				mix-blend-mode: overlay;
			}

			&.green {
				&:after {
					opacity: 1;
					animation: slide 3s infinite;
				}

				background-color: #2EAD5D;
			}

			&.orange {
				background-color: #D59700;
			}

			&.red {
				background-color: #D64111;
			}
		}

        .playerNo {
            color: #555e71;

            i {
                font-style: normal;
            }
        }
    }
</style>
