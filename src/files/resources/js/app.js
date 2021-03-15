import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App';
import Pusher from 'pusher-js';

window.Pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
  wsHost: window.location.hostname,
  wsPort: 6001,
  disableStats: true,
  authEndpoint: '/{{ request()->path() }}/auth',
  auth: {
    headers: {
      'X-CSRF-Token': "{{ csrf_token() }}",
      'X-App-ID': process.env.MIX_PUSHER_APP_ID
    }
  },
  enabledTransports: ['ws', 'flash'],
  useTLS: false,
  forceTLS: false
});

ReactDOM.render(<App />, document.getElementById("app"));
