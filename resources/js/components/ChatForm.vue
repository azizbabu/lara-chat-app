<template>
  <div class="input-group">
    <input 
      id="btn-input"
      type="text"
      name="message"
      class="form-control input-sm"
      placeholder="Type your message here..."
      v-model="newMessage"
      @keyup.enter="sendMessage"
    />
    <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">Send</button>
  </div>
</template>

<script>
export default {
  props: ['user'],
  data () {
    return {
      newMessage: ''
    }
  },
  methods: {
    sendMessage () {
      //Emit a "messagesent" event including the user who sent the message along with the message content
      this.$emit('messagesent', {
        user: this.user,
        //newMessage is bound to the earlier "btn-input" input field
        message: this.newMessage
      })
      //Clear the input
      this.newMessage = ""
    }
  }
}
</script>

<style>

</style>