const title = document.getElementById('auth-title');
const btn = document.getElementById('submitBtn');
const fields = document.getElementById('registerFields');
const action = document.getElementById('action');
const toggleText = document.getElementById('toggleText');

let register = false;

// EVENT DELEGATION (continua perfeito 👍)
toggleText.addEventListener('click', (e) => {

    if (e.target.id === 'toggleAuth') {
        e.preventDefault();

        register = !register;

        /* ===== ANIMAÇÃO DOS CAMPOS ===== */
        if (register) {
            fields.classList.add('show');
        } else {
            fields.classList.remove('show');
        }

        /* ===== TEXTOS ===== */
        title.textContent = register ? 'Criar Conta' : 'Fazer Login';
        btn.textContent   = register ? 'Cadastrar' : 'Entrar';
        action.value      = register ? 'register' : 'login';

        toggleText.innerHTML = register
            ? 'Já tem conta? <a href="#" id="toggleAuth">Entrar</a>'
            : 'Não tem conta? <a href="#" id="toggleAuth">Cadastre-se</a>';
    }
});
