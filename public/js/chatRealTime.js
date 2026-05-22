const messages_box = document.getElementById('messages-box')
const schoolId = document.getElementById('school').value
const chat = document.getElementById('chat').value
const user = Number.parseInt(document.getElementById('user').value)

const loadMessages = async () => {
    try {
        const request = await fetch (
            `http://localhost/_edu-connect/message/get_chat_messages/${encodeURIComponent(schoolId)}/${encodeURIComponent(chat)}`
        )

        const result = await request.json()
        
        renderMessages(result)
    } catch (error) {
        console.error("ERRO AO CARREGAR MENSAGENS: "+ error)
    }
}

const renderMessages = (messages) => {
    if (!messages || messages.length === 0) {
        messages_box.innerHTML = `<p>Nenhuma mensagem encontrada.</p>`
        return
    }

    let html = ''

    messages.forEach(message => {
        html += `
            ${message.user_id !== user ? 
                `
                    <div class="message received">
                        <div class="sender-profile">
                            ${message.user_foto !== "null" ?
                                    `<img src="http://localhost/_edu-connect/public/${message.user_foto}">`
                                :
                                    `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                                        <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                                        <circle cx="12" cy="11" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>`
                            }
                        </div>
                        <div class="message-box">
                            <div class="message-content">
                                <h4>${message.user}</h4>
                                <p>${message.conteudo}</p>
                            </div>
                            <span>${message.created_at}</span>
                        </div>
                    </div>
                ` 
                : 
                `
                    <div class="message sent">
                        <div class="sender-profile">
                            ${message.user_foto !== "null" ?
                                    `<img src="http://localhost/_edu-connect/public/${message.user_foto}">`
                                :
                                    `<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round-icon lucide-circle-user-round">
                                        <path d="M17.925 20.056a6 6 0 0 0-11.851.001" />
                                        <circle cx="12" cy="11" r="4" />
                                        <circle cx="12" cy="12" r="10" />
                                    </svg>`
                            }
                        </div>
                        <div class="message-box">
                            <div class="message-content">
                                <h4>${message.user}</h4>
                                <p>${message.conteudo}</p>
                            </div>
                            <span>${message.created_at}</span>
                        </div>
                    </div>
                `
            }
        `
    })

    messages_box.innerHTML = html
}

setInterval(loadMessages, 1000)