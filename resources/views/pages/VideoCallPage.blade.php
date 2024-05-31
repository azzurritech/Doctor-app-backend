@extends('layouts.dashboard')
@section('content')
<!DOCTYPE html>
  <html lang="en">
  <!-- begin::Head -->
  
  <!-- end::Head -->
  <!-- begin::Body -->
  <style type="text/css">
      .kt-form__help {
          color: red !important;
      }

      #join-btn-wrapper {
          position: fixed;
          top: 50%;
          left: 50%;
          font-size: 18px;
          padding: 20px 40px;
          transform: translateX(-50%);
      }

      #video-streams {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
          height: 90vh;
          width: 1400px;
          margin: 0 auto;
      }

      .video-container {
          max-height: 100%;
          border: 2px solid black;
          background-color: #203A49;
      }

      .video-player {
          height: 100%;
          width: 100%;
      }

      #stream-controls {
          display: none;
          justify-content: center;
          margin-top: 0.5em;
          bottom: 17px;
          right: 50%;
          transform: translateX(50%);
      }

      @media screen and (max-width:1400px) {
          #video-streams {
              grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
              width: 95%;
          }
      }
    [class*="loader-"] {
        display: inline-block;
        width: 1em;
        height: 1em;
        color: inherit;
        vertical-align: middle;
        pointer-events: none;
    }
    .loader-03 {
        border: .2em solid currentcolor;
        border-bottom-color: transparent;
        border-radius: 50%;
        animation: 1s loader-03 linear infinite;
        position: relative;
    }

    @keyframes loader-03 {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .header-bottom{
        display: none !important;
    }
  </style>
  
  <body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading" onload="joinStream()">
    <input type="hidden" id="appToken" value="{{ env('CALL_TOKEN') }}">
      <div class="position-relative">
          <div id="stream-wrapper">
              <div id="video-streams"></div>

              <div id="stream-controls" class="position-absolute top-100 start-50 translate-middle align-items-center">
                  <div id="mic-btn"
                      class="btn btn-icon rounded-circle btn-hover-transparent-white btn-lg d-flex justify-content-center align-items-center mr-2"
                      style="background:#0D9DA6;">
                      <i class="fas fa-microphone"></i>
                  </div>
                  <div id="camera-btn"
                      class="btn btn-icon rounded-circle btn-hover-transparent-white btn-lg d-flex justify-content-center align-items-center mr-2"
                      style="background:#0D9DA6;">
                      <i class="fas fa-video"></i>
                  </div>
                  <button id="leave-btn" class="btn btn-danger btn-lg">Leave Call</button>
              </div>
          </div>
          <div id="join-btn-wrapper" class="d-flex align-items-center justify-content-center">
            <div id="loader" class="loader-03"></div>
              <button class="btn btn-primary btn-lg mr-2" id="join-btn"  style="display: none;">Join Again</button>
              <a class="btn btn-primary btn-lg" id="dashboard-btn" style="display: none;" href="{{ route('dashboard') }}">Back to dashboard</a>
          </div>
      </div>

      <!-- <div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
          <a href="{{ route('dashboard') }}">
              <img alt="Logo" src="{{ asset('media/logos/logo-dot.svg') }}" class="max-h-60px" />

          </a>

          <div class="d-flex align-items-center">
              <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
                  <span></span>
              </button>
              <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                  <span class="svg-icon svg-icon-xl">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                          height="24px" viewBox="0 0 24 24" version="1.1">
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <polygon points="0 0 24 0 24 24 0 24" />
                              <path
                                  d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                  fill="#000000" fill-rule="nonzero" opacity="0.3" />
                              <path
                                  d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                  fill="#000000" fill-rule="nonzero" />
                          </g>
                      </svg>
                  </span>
              </button>
          </div>
      </div> -->
      <div class="d-flex flex-column flex-root main-web">

          <div class="d-flex flex-row flex-column-fluid page">

              <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!-- headerbar include here -->
              </div>
          </div>

      </div>
      <!-- footer include here -->
      @stack('scripts')
  </body>
  <script src="{{ asset('js/VideoCallPlugin.js') }}"></script>
  <script type="text/javascript">
      $('ul.nav > li').click(function(e) {
          var getItem = $(this).text().replace(/\s/g, '');
          var id = '#id_' + getItem + ' .menu-nav .menu-item';
          console.log(id);
          var urlpage = $(id).find('a:first').attr('href');
          console.log(urlpage);
          window.location.href = urlpage;
      });
  </script>
  <script>
      const APP_ID = "6c066cba675c4bc6ba6ed43f51b7ccc7";
      const TOKEN = document.querySelector('#appToken').value;
      const CHANNEL = "pharmacy_app";
      const client = AgoraRTC.createClient({mode: 'rtc', codec: 'vp8'});
      let localTracks = []
      let remoteUsers = {}
      console.log(TOKEN, APP_ID, CHANNEL, 'console const value');
      let joinAndDisplayLocalStream = async () => {
          client.on('user-published', handleUserJoined)
          client.on('user-left', handleUserLeft)
          let UID = await client.join(APP_ID, 'pharmacy_app', TOKEN, null)
          localTracks = await AgoraRTC.createMicrophoneAndCameraTracks()
          let player = `<div class="video-container" id="user-container-${UID}">
                        <div class="video-player" id="user-${UID}"></div>
                  </div>`
          document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)
          localTracks[1].play(`user-${UID}`)
          await client.publish([localTracks[0], localTracks[1]])
      }

      let joinStream = async () => {
          document.getElementById('loader').style.display = 'block'
          document.getElementById('join-btn').style.display = 'none'
          document.getElementById('dashboard-btn').style.display = 'none'
          await joinAndDisplayLocalStream()
          document.getElementById('loader').style.display = 'none'
          document.getElementById('stream-controls').style.display = 'flex'
      }

      let handleUserJoined = async (user, mediaType) => {
          remoteUsers[user.uid] = user
          await client.subscribe(user, mediaType)

          if (mediaType === 'video') {
              let player = document.getElementById(`user-container-${user.uid}`)
              if (player != null) {
                  player.remove()
              }

              player = `<div class="video-container" id="user-container-${user.uid}">
                        <div class="video-player" id="user-${user.uid}"></div>
                 </div>`
              document.getElementById('video-streams').insertAdjacentHTML('beforeend', player)

              user.videoTrack.play(`user-${user.uid}`)
          }

          if (mediaType === 'audio') {
              user.audioTrack.play()
          }
      }

      let handleUserLeft = async (user) => {
          delete remoteUsers[user.uid]
          document.getElementById(`user-container-${user.uid}`).remove()
      }

      let leaveAndRemoveLocalStream = async () => {
          for (let i = 0; localTracks.length > i; i++) {
              localTracks[i].stop()
              localTracks[i].close()
          }

          await client.leave()
          document.getElementById('join-btn').style.display = 'block'
          document.getElementById('dashboard-btn').style.display = 'block'
          document.getElementById('stream-controls').style.display = 'none'
          document.getElementById('video-streams').innerHTML = ''
      }

      let toggleMic = async (e) => {
          if (localTracks[0].muted) {
              await localTracks[0].setMuted(false)
              document.getElementById('mic-btn').style.backgroundColor = '#0D9DA6'
              document.querySelector('.fa-microphone').classList.remove('fa-microphone-slash')
          } else {
              await localTracks[0].setMuted(true)
              document.getElementById('mic-btn').style.backgroundColor = '#EE4B2B'
              document.querySelector('.fa-microphone').classList.add('fa-microphone-slash')
          }
      }

      let toggleCamera = async (e) => {
          if (localTracks[1].muted) {
              await localTracks[1].setMuted(false)
              document.getElementById('camera-btn').style.backgroundColor = '#0D9DA6'
              document.querySelector('.fa-video').classList.remove('fa-video-slash')
          } else {
              await localTracks[1].setMuted(true)
              document.getElementById('camera-btn').style.backgroundColor = '#EE4B2B'
              document.querySelector('.fa-video').classList.add('fa-video-slash')
          }
      }

      document.getElementById('join-btn').addEventListener('click', joinStream)
      document.onLoad = joinStream();
      document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream)
      document.getElementById('mic-btn').addEventListener('click', toggleMic)
      document.getElementById('camera-btn').addEventListener('click', toggleCamera)
  </script>

  </html>
  @endsection