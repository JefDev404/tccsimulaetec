document.addEventListener('DOMContentLoaded', function() {
    const config = window.SIMULAETEC_CONFIG || {}; 
    const PROVA3_ASSETS = config.PROVA3_ASSETS || '';

    // 2. Elementos da página
    const nextQuestBtn = document.getElementById('nextQuestBtn');
    const questImage = document.getElementById('questImage');
    const radioInputs = document.querySelectorAll('input[name="answer"]');
    const timerElement = document.getElementById("timer")
    const gerarBtn = document.getElementById("gerarBtn");
    const answerForm = document.querySelector('.answer-form');

 // 3. Lista de questões (usando caminhos relativos como no seu JS original)
 const questions = [
    { image: PROVA3_ASSETS + 'imgs/imgprovas/intro.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest1a2img.png', requiresAnswer: false},
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest1.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest2.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest3.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest4.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest5a7img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest5.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest6.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest7.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest8.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest9a11img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest9.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest10.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest11.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest12.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest13a15img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest13.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest14.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest15.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest16a17img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest16.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest17.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest18.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest19a21img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest19.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest20.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest21.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest22.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest23.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest24.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest25.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest25a27img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest26.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest27.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest28a29img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest28.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest29.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest30.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest31.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest32.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest33.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest34.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest35.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest36.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest37.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest38.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest39a42img.png', requiresAnswer: false },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest39.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest40.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest41.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest42.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest43.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest44.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest45.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest46.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest47.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest48.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest49.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/quest50.png', requiresAnswer: true },
    { image: PROVA3_ASSETS + 'imgs/imgprovas/gabarito.png', requiresAnswer: false }
];


    // 4. Variáveis de estado
    let currentIndex = 0;
    let questaoIndex = 1;
    let respostas = [];
    let tempoTotal = 4 * 60 * 60;
    let tempoInicial = tempoTotal;
    let tempoEsgotado = false;
    let contador;
    let provaIniciada = false; // Novo estado

    // 5. Função para carregar questões 
    function loadQuestion(index) {
        const quest = questions[index];
        questImage.src = quest.image;
        questImage.style.display = 'block';
        radioInputs.forEach(input => input.checked = false);

        // Modificado para controlar o formulário de respostas
        if (index === 0) {
            answerForm.style.display = 'none';
            nextQuestBtn.textContent = 'Iniciar Prova';
            nextQuestBtn.style.backgroundColor = '#4CAF50'; // Verde
        } else {
            answerForm.style.display = 'block';
            nextQuestBtn.textContent = 'Próxima Questão';
            nextQuestBtn.style.backgroundColor = '#3277bd'; // Azul padrão
        }

        if (quest.requiresAnswer) {
            nextQuestBtn.disabled = true;
        } else {
            nextQuestBtn.disabled = false;
        }
    }

       // 6. Funções auxiliares 
       function isAnswerSelected() {
        return [...radioInputs].some(input => input.checked);
    }

    // 7. Event listeners modificados
    radioInputs.forEach(input => {
        input.addEventListener('change', () => {
            if (questions[currentIndex].requiresAnswer && provaIniciada) {
                nextQuestBtn.disabled = !isAnswerSelected();
            }
        });
    });

    nextQuestBtn.addEventListener('click', () => {
        if (!provaIniciada && currentIndex === 0) {
            provaIniciada = true;
            iniciarTimer();
        }

        const quest = questions[currentIndex];
        const selectedOption = [...radioInputs].find(input => input.checked);
    
        if (quest.requiresAnswer && provaIniciada) {
            respostas[questaoIndex] = selectedOption ? selectedOption.value : "-";
            questaoIndex++;
        }
    
        if (currentIndex < questions.length - 1) {
            currentIndex++;
            loadQuestion(currentIndex);
    
            if (currentIndex === questions.length - 1) {
                gerarBtn.style.display = "inline-block";
            }
        } else {
            nextQuestBtn.disabled = true;
            alert('Você chegou à última questão! Agora clique em "Gerar Respostas" para salvar o gabarito.');
        }
    });



     // 8. Timer 
     function iniciarTimer() {
        if (!contador) {
            contador = setInterval(atualizarTimer, 1000);
        }
    }

    function atualizarTimer() {
        let horas = Math.floor(tempoTotal / 3600);
        let minutos = Math.floor((tempoTotal % 3600) / 60);
        let segundos = tempoTotal % 60;

        timerElement.textContent = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;

        let porcentagem = tempoTotal / tempoInicial;
        if (porcentagem <= 0.1) {
            timerElement.style.color = "red";
        } else if (porcentagem <= 0.5) {
            timerElement.style.color = "yellow";
        } else {
            timerElement.style.color = "green  rgb(6, 243, 6)";
        }

        if (tempoTotal <= 0 && !tempoEsgotado) {
            tempoEsgotado = true;
            clearInterval(contador);
            timerElement.textContent = "Tempo esgotado";
            timerElement.style.color = "red";
        } else {
            tempoTotal--;
        }
    }



 // 9. Função para gerar arquivo 
 window.gerarArquivo = function() {
    const texto = respostas
        .map((resp, i) => (i > 0 ? `${i}${resp}` : null))
        .filter(Boolean)
        .join(", ");

    const blob = new Blob([texto], { type: "text/plain" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "respostas.txt";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    let outputDiv = document.getElementById("respostasPrint");
    if (!outputDiv) {
        outputDiv = document.createElement("div");
        outputDiv.id = "respostasPrint";
        outputDiv.style.marginTop = "20px";
        outputDiv.style.fontSize = "18px";
        outputDiv.style.fontFamily = "monospace";
        outputDiv.style.display = "none";
        document.body.appendChild(outputDiv);
    }

    outputDiv.style.display = "block";
    outputDiv.innerHTML = `<strong>suas respostas:</strong><br>${texto}`;
};

    // 10. Inicialização
    loadQuestion(0); // Carrega a primeira questão
    questImage.style.display = 'block';

    // Efeitos visuais
    document.body.classList.add('loaded');
    const elements = document.querySelectorAll('.animate-onload');
    elements.forEach(el => {
        el.style.opacity = '0';
    });
});