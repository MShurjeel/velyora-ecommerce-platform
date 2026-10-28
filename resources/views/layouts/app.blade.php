<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Velyora - Modern Everyday Essentials')</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <script>
        window.Velyora = {
            baseUrl: "{{ url('/') }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
</head>

<body>

    @include('partials.header')
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/checkout.js') }}"></script>

    @stack('scripts')


    <!-- Chat Widget Styling -->
    <style>
        #chat-widget-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }

        #chat-widget-box {
            position: fixed;
            bottom: 85px;
            right: 20px;
            width: 330px;
            height: 440px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            display: none;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            font-family: Arial, sans-serif;
        }

        #chat-header {
            background: #2563eb;
            color: #ffffff;
            padding: 12px 16px;
            font-weight: bold;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        #chat-messages {
            flex: 1;
            padding: 12px;
            overflow-y: auto;
            font-size: 14px;
        }

        .chat-msg {
            margin-bottom: 10px;
            max-width: 80%;
            padding: 8px 12px;
            border-radius: 8px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .chat-msg.user {
            background: #e0f2fe;
            margin-left: auto;
            color: #0369a1;
        }

        .chat-msg.bot {
            background: #f3f4f6;
            margin-right: auto;
            color: #1f2937;
        }

        #chat-input-bar {
            display: flex;
            border-top: 1px solid #e5e7eb;
            padding: 8px;
        }

        #chat-input {
            flex: 1;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 6px 10px;
            outline: none;
            font-size: 14px;
        }

        #chat-send-btn {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            margin-left: 6px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>

    <!-- Chat Widget Markup -->
    <button id="chat-widget-btn" onclick="toggleChatBox()">💬</button>

    <div id="chat-widget-box">
        <div id="chat-header">Store Customer Support</div>
        <div id="chat-messages">
            <div class="chat-msg bot">Hello! How can I assist you with our products today?</div>
        </div>
        <div id="chat-input-bar">
            <input type="text" id="chat-input" placeholder="Ask a question..." onkeypress="handleEnter(event)">
            <button id="chat-send-btn" onclick="sendChatMessage()">Send</button>
        </div>
    </div>

    <!-- Chat Widget Script -->
    <script>
        function toggleChatBox() {
            const box = document.getElementById('chat-widget-box');
            box.style.display = (box.style.display === 'flex') ? 'none' : 'flex';
        }

        function handleEnter(e) {
            if (e.key === 'Enter') sendChatMessage();
        }

        async function sendChatMessage() {
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if (!text) return;

            const container = document.getElementById('chat-messages');

            // Render user message
            container.innerHTML += `<div class="chat-msg user">${escapeHtml(text)}</div>`;
            input.value = '';
            container.scrollTop = container.scrollHeight;

            // Render temporary loading indicator
            const tempId = 'loading-' + Date.now();
            container.innerHTML += `<div class="chat-msg bot" id="${tempId}">Thinking...</div>`;
            container.scrollTop = container.scrollHeight;

            // Get CSRF token safely from meta tag or Blade directive
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            try {
                const response = await fetch('/chatbot/message', { // Updated path for web.php
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                document.getElementById(tempId).remove();

                if (response.ok && data.status === 'success') {
                    container.innerHTML += `<div class="chat-msg bot">${escapeHtml(data.reply)}</div>`;
                } else {
                    console.error('Server error response:', data);
                    container.innerHTML += `<div class="chat-msg bot">${escapeHtml(data.message || 'An error occurred while getting a response.')}</div>`;
                }
            } catch (err) {
                console.error('Fetch exception:', err);
                document.getElementById(tempId).remove();
                container.innerHTML += `<div class="chat-msg bot">Connection error. Please try again.</div>`;
            }
            container.scrollTop = container.scrollHeight;
        }

        function escapeHtml(str) {
            return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        } 
    </script>

</body>

</html>