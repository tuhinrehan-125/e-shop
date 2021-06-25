<template>
  <base-material-dash-card
    :icon="icon"
    class="v-card--material-stats"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <template v-slot:after-heading>
      <div class="ml-auto">
        <div
          class="body-2 grey--text font-weight-light mb-2"
          v-text="title"
        />

        <h3 class="title">
          {{ value }} <small>{{ smallValue }}</small>
        </h3>
      </div>
    </template>
  </base-material-dash-card>
</template>

<script>
  import Card from './Card'

  export default {
    name: 'MaterialStatsCard',

    inheritAttrs: false,

    props: {
      ...Card.props,
      icon: {
        type: String,
        required: false,
      },
      subIcon: {
        type: String,
        default: undefined,
      },
      subIconColor: {
        type: String,
        default: undefined,
      },
      subTextColor: {
        type: String,
        default: undefined,
      },
      subText: {
        type: String,
        default: undefined,
      },
      title: {
        type: String,
        default: undefined,
      },
      value: {
        type: String,
        default: undefined,
      },
      smallValue: {
        type: String,
        default: undefined,
      },
    },
  }
</script>

<style lang="sass">
.v-card--material-stats
  display: flex
  flex-wrap: wrap
  position: relative

  > div:first-child
    justify-content: space-between

  .v-card
    border-radius: 4px
    flex: 0 1 auto

  .v-card__text
    display: inline-block
    flex: 1 0 calc(100% - 120px)
    position: absolute
    top: 0
    right: 0
    width: 100%

  .v-card__actions
    flex: 1 0 100%
</style>
