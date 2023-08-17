const axios = require('axios');
const cheerio = require('cheerio');

async function chatgpt(chat) {
  try {
    const response = await axios.get('https://chatgpt.ai/');
    const $ = cheerio.load(response.data);
    const nonce = $('div[data-nonce]').attr('data-nonce');
    const post_id = $('div[data-post-id]').attr('data-post-id');
    const bot_id = $('div[data-bot-id]').attr('data-bot-id');

    const headers = {
      'authority': 'chatgpt.ai',
      'origin': 'https://chatgpt.ai',
      'pragma': 'no-cache',
      'referer': 'https://chatgpt.ai/gpt-4/',
      'user-agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
    };

    const data = new URLSearchParams();
    data.append('_wpnonce', nonce);
    data.append('post_id', post_id);
    data.append('url', 'https://chatgpt.ai/gpt-4');
    data.append('action', 'wpaicg_chat_shortcode_message');
    data.append('message', chat);
    data.append('bot_id', bot_id);

    const response2 = await axios.post('https://chatgpt.ai/wp-admin/admin-ajax.php', data, { headers });

    return response2.data.data;
  } catch (error) {
    console.error(error);
    return null;
  }
}

(async () => {
  const result = await chatgpt("who is elon musk");
  console.log(result);
})();
