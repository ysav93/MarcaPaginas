const $ = seletor => document.querySelector(seletor);

const $$ = seletor => document.querySelectorAll(seletor);




const placeholder =
    "https://placehold.co/400x600/f3e6e9/85001b?text=MarcaPagina";




const defaultData = {

    books: [

        {
            id: 1,

            title: "Memórias Póstumas de Brás Cubas",

            author: "Machado de Assis",

            publisher: "Editora Ática",

            genre: "Romance",

            status: "lendo",

            total: 352,

            read: 229,

            image: "https://covers.openlibrary.org/b/id/12818862-L.jpg",

            review: "Uma leitura cheia de ironia e reflexões."
        },

        {
            id: 2,

            title: "Dom Casmurro",

            author: "Machado de Assis",

            publisher: "Principis",

            genre: "Romance",

            status: "quero",

            total: 256,

            read: 0,

            image: "https://covers.openlibrary.org/b/id/8259251-L.jpg",

            review: ""
        },

        {
            id: 3,

            title: "A Hora da Estrela",

            author: "Clarice Lispector",

            publisher: "Rocco",

            genre: "Romance",

            status: "lido",

            total: 88,

            read: 88,

            image: "https://covers.openlibrary.org/b/id/10958366-L.jpg",

            review: "Uma obra curta e marcante."
        }

    ],


    groups: [],


    communities: [

        {
            id: 1,

            name: "Clube dos Clássicos",

            description: "Um espaço para conversar sobre obras que atravessam gerações.",

            image: "",

            members: 8,

            joined: true,

            owner: false
        },

        {
            id: 2,

            name: "Fantasia & Ficção",

            description: "Dragões, mundos imaginários e histórias inesquecíveis.",

            image: "",

            members: 15,

            joined: false,

            owner: false
        }

    ],


    messages: {}

};




let state =
    JSON.parse(
        localStorage.getItem("marcaPaginaData")
    ) ||
    defaultData;


let currentFilter = "todos";

let communityFilter = "minhas";

let activeBookId = null;

let activeChat = null;



function save() {

    localStorage.setItem(
        "marcaPaginaData",
        JSON.stringify(state)
    );

}




function esc(valor = "") {

    return String(valor).replace(
        /[&<>"']/g,

        caractere => ({

            "&": "&amp;",

            "<": "&lt;",

            ">": "&gt;",

            '"': "&quot;",

            "'": "&#039;"

        })[caractere]
    );

}




function pct(book) {

    if (!book.total) {

        return 0;

    }

    return Math.max(

        0,

        Math.min(

            100,

            Math.round(
                book.read /
                book.total *
                100
            )

        )

    );

}




function statusName(status) {

    if (status === "lendo") {

        return "Lendo";

    }

    if (status === "lido") {

        return "Lido";

    }

    return "Quero ler";

}




function toast(mensagem) {

    const elemento = $("#toast");

    elemento.textContent = mensagem;

    elemento.classList.add(
        "show-toast"
    );

    setTimeout(() => {

        elemento.classList.remove(
            "show-toast"
        );

    }, 2500);

}




function openModal(id) {

    $("#" + id).classList.add(
        "show"
    );

}




function closeModal(id) {

    $("#" + id).classList.remove(
        "show"
    );

}




function renderDashboard() {

    const books =
        state.books;


    const reading =
        books.filter(
            book =>
            book.status === "lendo"
        );


    const read =
        books.filter(
            book =>
            book.status === "lido"
        );


    const pages =
        books.reduce(

            (total, book) =>

            total +
            Number(book.read || 0),

            0

        );


    $("#statTotal").textContent =
        books.length;


    $("#statReading").textContent =
        reading.length;


    $("#statRead").textContent =
        read.length;


    $("#statPages").textContent =
        pages;


    const average =
        books.length

        ?

        Math.round(

            books.reduce(

                (total, book) =>
                total +
                pct(book),

                0

            ) /
            books.length

        )

    :

    0;


    $("#goalPercent").textContent =
        average + "%";


    $("#goalRing").style.background =
        `conic-gradient(
            var(--wine)
            ${average * 3.6}deg,
            #f2e7e9 0deg
        )`;


    if (reading.length) {

        const book =
            reading[0];


        $("#currentReading").innerHTML = `

            <div class="current-reading">

                <img
                    src="${esc(book.image || placeholder)}"

                    onerror="
                        this.src='${placeholder}'
                    ">

                <div class="book-progress">

                    <span class="badge lendo">

                        LENDO AGORA

                    </span>

                    <h3>

                        ${esc(book.title)}

                    </h3>

                    <p class="muted">

                        ${esc(book.author)}

                    </p>


                    <div class="progress">

                        <i
                            style="
                                width:
                                ${pct(book)}%
                            ">
                        </i>

                    </div>


                    <div class="progress-label">

                        <span>

                            ${book.read}
                            de
                            ${book.total}
                            páginas

                        </span>


                        <strong>

                            ${pct(book)}%

                        </strong>

                    </div>

                </div>

            </div>

        `;

    } else {

        $("#currentReading").innerHTML = `

            <div class="empty">

                <div>
                    📖
                </div>

                <h2>
                    Nenhuma leitura em andamento
                </h2>

                <p>
                    Cadastre um livro e marque-o como “Lendo”.
                </p>

            </div>

        `;

    }


    $("#activityList").innerHTML =
        books
        .slice(-4)
        .reverse()
        .map(book => `

                <div class="activity">

                    📚

                    <strong>

                        ${esc(book.title)}

                    </strong>

                    —

                    ${pct(book)}%
                    concluído

                </div>

            `)
        .join("");

}




function renderBooks() {

    const search =
        $("#bookSearch")
        .value
        .toLowerCase();


    const filtered =
        state.books.filter(book => {

            const matchesFilter =
                currentFilter === "todos"

            ||

            book.status ===
                currentFilter;


            const searchableText = [
                    book.title,
                    book.author,
                    book.publisher,
                    book.genre
                ]
                .join(" ")
                .toLowerCase();


            return (
                matchesFilter &&
                searchableText.includes(search)
            );

        });


    $("#booksGrid").innerHTML =
        filtered.map(book => `

            <article
                class="book-card"
                data-book="${book.id}">

                <img

                    class="book-cover"

                    src="
                        ${esc(
                            book.image ||
                            placeholder
                        )}
                    "

                    onerror="
                        this.src='${placeholder}'
                    ">


                <h3>

                    ${esc(book.title)}

                </h3>


                <p>

                    ${esc(book.author)}

                </p>


                <div class="progress">

                    <i
                        style="
                            width:
                            ${pct(book)}%
                        ">

                    </i>

                </div>


                <div class="card-bottom">

                    <span
                        class="
                            badge
                            ${book.status}
                        ">

                        ${statusName(book.status)}

                    </span>


                    <strong>

                        ${pct(book)}%

                    </strong>

                </div>

            </article>

        `).join("");


    $("#emptyBooks").classList.toggle(

        "hidden",

        filtered.length !== 0

    );


    $("#libraryCount").textContent =
        state.books.length;


    $("#countTodos").textContent =
        state.books.length;


    $("#countLendo").textContent =
        state.books.filter(

            book =>
            book.status === "lendo"

        ).length;


    $("#countQuero").textContent =
        state.books.filter(

            book =>
            book.status === "quero"

        ).length;


    $("#countLido").textContent =
        state.books.filter(

            book =>
            book.status === "lido"

        ).length;


    $$(".book-card").forEach(card => {

        card.onclick = () => {

            showBook(
                Number(card.dataset.book)
            );

        };

    });

}




function showBook(id) {

    const book =
        state.books.find(

            item =>
            item.id === id

        );


    activeBookId = id;


    $("#bookDetail").innerHTML = `

        <div class="detail-layout">

            <img

                class="detail-cover"

                src="
                    ${esc(
                        book.image ||
                        placeholder
                    )}
                "

                onerror="
                    this.src='${placeholder}'
                ">


            <div class="detail-info">

                <span
                    class="
                        badge
                        ${book.status}
                    ">

                    ${statusName(book.status)}

                </span>


                <h2>

                    ${esc(book.title)}

                </h2>


                <p class="muted">

                    ${esc(book.author)}

                </p>


                <p>

                    <strong>
                        Editora:
                    </strong>

                    ${esc(
                        book.publisher ||
                        "Não informada"
                    )}

                </p>


                <p>

                    <strong>
                        Gênero:
                    </strong>

                    ${esc(
                        book.genre ||
                        "Não informado"
                    )}

                </p>


                <div class="book-progress">

                    <div class="progress">

                        <i
                            style="
                                width:
                                ${pct(book)}%
                            ">

                        </i>

                    </div>


                    <div class="progress-label">

                        <span>

                            ${book.read}
                            de
                            ${book.total}
                            páginas

                        </span>


                        <strong>

                            ${pct(book)}%

                        </strong>

                    </div>

                </div>

            </div>

        </div>


        <div class="review-box">

            <strong>
                Sua resenha
            </strong>

            <p>

                ${esc(
                    book.review ||
                    "Nenhuma resenha adicionada."
                )}

            </p>

        </div>


        <div class="detail-actions">

            <button
                id="editBook"
                class="secondary">

                ✎ Editar

            </button>


            <button
                id="deleteBook"
                class="primary">

                Excluir livro

            </button>

        </div>

    `;


    $("#editBook").onclick = () => {

        editBook(id);

    };


    $("#deleteBook").onclick = () => {

        if (
            confirm(
                "Excluir este livro?"
            )
        ) {

            state.books =
                state.books.filter(

                    book =>
                    book.id !== id

                );


            save();

            closeModal(
                "bookDetailModal"
            );


            renderAll();


            toast(
                "Livro excluído."
            );

        }

    };


    openModal(
        "bookDetailModal"
    );

}




function editBook(id) {

    const book =
        state.books.find(

            item =>
            item.id === id

        );


    $("#bookId").value =
        book.id;


    $("#bookTitle").value =
        book.title;


    $("#bookAuthor").value =
        book.author;


    $("#bookPublisher").value =
        book.publisher || "";


    $("#bookGenre").value =
        book.genre || "";


    $("#bookStatus").value =
        book.status;


    $("#bookTotalPages").value =
        book.total;


    $("#bookReadPages").value =
        book.read;


    $("#bookImage").value =
        book.image || "";


    $("#bookReview").value =
        book.review || "";


    $("#bookModalTitle").textContent =
        "Editar livro";


    updatePreview();


    closeModal(
        "bookDetailModal"
    );


    openModal(
        "bookModal"
    );

}




function resetBookForm() {

    $("#bookForm").reset();

    $("#bookId").value = "";

    $("#bookReadPages").value = 0;

    $("#bookModalTitle").textContent =
        "Cadastrar livro";


    updatePreview();

}




function updatePreview() {

    const total =
        Number(
            $("#bookTotalPages").value
        ) ||
        0;


    const read =
        Number(
            $("#bookReadPages").value
        ) ||
        0;


    const percentage =
        total

        ?

        Math.min(
            100,

            Math.round(
                read /
                total *
                100
            )
        )

    :

    0;


    $("#previewProgress").style.width =
        percentage + "%";


    $("#previewPercent").textContent =
        percentage + "%";

}




$("#bookForm").onsubmit =
    event => {

        event.preventDefault();


        const id =
            $("#bookId").value;


        const total =
            Number(
                $("#bookTotalPages").value
            );


        const read =
            Math.min(

                Number(
                    $("#bookReadPages").value
                ),

                total

            );


        const book = {

            id: id ?
                Number(id) :
                Date.now(),

            title: $("#bookTitle").value.trim(),

            author: $("#bookAuthor").value.trim(),

            publisher: $("#bookPublisher").value.trim(),

            genre: $("#bookGenre").value.trim(),

            status: $("#bookStatus").value,

            total,

            read,

            image: $("#bookImage").value.trim(),

            review: $("#bookReview").value.trim()

        };


        if (
            book.status === "lido"
        ) {

            book.read =
                total;

        }


        if (id) {

            state.books =
                state.books.map(

                    item =>

                    item.id === book.id

                    ?

                    book

                    :

                    item

                );

        } else {

            state.books.push(
                book
            );

        }


        save();


        closeModal(
            "bookModal"
        );


        renderAll();


        toast(

            id

            ?

            "Livro atualizado!"

            :

            "Livro cadastrado!"

        );

    };




function renderGroups() {

    $("#groupsGrid").innerHTML =
        state.groups
        .map(group =>

            socialCard(
                group,
                "group"
            )

        )
        .join("");


    $("#emptyGroups").classList.toggle(

        "hidden",

        state.groups.length !== 0

    );


    bindSocialCards();

}




function socialCard(item, type) {

    const background =
        item.image

        ?

        `style="
                background-image:
                url('${esc(item.image)}')
            "`

    :

    "";


    const joined =
        type === "group" ||
        item.joined;


    return `

        <article class="social-card">

            <div
                class="social-banner"
                ${background}>

            </div>


            <div class="social-content">

                <span class="eyebrow dark">

                    ${
                        type === "group"

                            ?

                            "GRUPO PRIVADO"

                            :

                            "COMUNIDADE PÚBLICA"
                    }

                </span>


                <h2>

                    ${esc(item.name)}

                </h2>


                <p>

                    ${esc(item.description)}

                </p>


                <div class="meta">

                    <span>

                        👥
                        ${item.members || 1}

                        ${
                            type === "group"

                                ?

                                " / " + item.max

                                :

                                ""
                        }

                        participantes

                    </span>


                    ${
                        type === "group"

                            ?

                            `
                                <span>
                                    🔑 ${item.key}
                                </span>
                            `

                            :

                            ""
                    }

                </div>


                <div class="social-actions">

                    ${
                        joined

                            ?

                            `
                                <button
                                    class="
                                        primary
                                        open-chat
                                    "

                                    data-type="${type}"

                                    data-id="${item.id}">

                                    💬 Abrir chat

                                </button>
                            `

                            :

                            `
                                <button
                                    class="
                                        primary
                                        join-community
                                    "

                                    data-id="${item.id}">

                                    Entrar

                                </button>
                            `
                    }


                    ${
                        item.owner ||
                        type === "group"

                            ?

                            `
                                <button
                                    class="
                                        secondary
                                        delete-social
                                    "

                                    data-type="${type}"

                                    data-id="${item.id}">

                                    Excluir

                                </button>
                            `

                            :

                            ""
                    }

                </div>

            </div>

        </article>

    `;

}




function bindSocialCards() {

    $$(".open-chat").forEach(button => {

        button.onclick = () => {

            openChat(

                button.dataset.type,

                Number(
                    button.dataset.id
                )

            );

        };

    });


    $$(".delete-social").forEach(button => {

        button.onclick = () => {

            const type =
                button.dataset.type;


            const key =
                type === "group"

                    ?

                    "groups"

                    :

                    "communities";


            if (
                confirm(
                    "Deseja excluir este espaço?"
                )
            ) {

                state[key] =
                    state[key].filter(

                        item =>

                            item.id !==
                            Number(
                                button.dataset.id
                            )

                    );


                save();


                renderGroups();


                renderCommunities();


                toast(
                    "Excluído com sucesso."
                );

            }

        };

    });


    $$(".join-community").forEach(button => {

        button.onclick = () => {

            const community =
                state.communities.find(

                    item =>

                        item.id ===
                        Number(
                            button.dataset.id
                        )

                );


            community.joined = true;

            community.members++;


            save();


            renderCommunities();


            toast(
                "Você entrou na comunidade!"
            );

        };

    });

}




function randomKey() {

    return String(

        Math.floor(
            100000 +
            Math.random() *
            900000
        )

    );

}


$("#groupForm").onsubmit =
    event => {

        event.preventDefault();


        const key =
            randomKey();


        const group = {

            id:
                Date.now(),

            name:
                $("#groupName")
                    .value
                    .trim(),

            description:
                $("#groupDescription")
                    .value
                    .trim(),

            image:
                $("#groupImage")
                    .value
                    .trim(),

            max:
                Number(
                    $("#groupMax")
                        .value
                ),

            members: 1,

            key,

            owner: true

        };


        state.groups.push(
            group
        );


        save();


        $("#groupForm").reset();


        closeModal(
            "groupModal"
        );


        $("#generatedKey").textContent =
            key;


        openModal(
            "keyModal"
        );


        renderGroups();


        toast(
            "Grupo criado!"
        );

    };



$("#copyKey").onclick =
    async () => {

        try {

            await navigator.clipboard.writeText(

                $("#generatedKey")
                    .textContent

            );


            toast(
                "Chave copiada!"
            );

        }

        catch {

            toast(
                "Chave: " +
                $("#generatedKey")
                    .textContent
            );

        }

    };




$("#joinGroupForm").onsubmit =
    event => {

        event.preventDefault();


        const key =
            $("#joinKey")
                .value
                .trim();


        const group =
            state.groups.find(

                item =>
                    item.key === key

            );


        if (!group) {

            toast(
                "Chave não encontrada."
            );

            return;

        }


        if (
            group.members >=
            group.max
        ) {

            toast(
                "Este grupo já atingiu o limite."
            );

            return;

        }


        group.members++;


        save();


        $("#joinGroupForm").reset();


        closeModal(
            "joinGroupModal"
        );


        renderGroups();


        toast(
            "Você entrou no grupo!"
        );

    };




function renderCommunities() {

    const communities =
        state.communities.filter(

            community =>

                communityFilter === "minhas"

                    ?

                    community.joined

                    :

                    !community.joined

        );


    $("#communitiesGrid").innerHTML =
        communities
            .map(community =>

                socialCard(
                    community,
                    "community"
                )

            )
            .join("");


    $("#emptyCommunities").classList.toggle(

        "hidden",

        communities.length !== 0

    );


    bindSocialCards();

}




$("#communityForm").onsubmit =
    event => {

        event.preventDefault();


        state.communities.push({

            id:
                Date.now(),

            name:
                $("#communityName")
                    .value
                    .trim(),

            description:
                $("#communityDescription")
                    .value
                    .trim(),

            image:
                $("#communityImage")
                    .value
                    .trim(),

            members: 1,

            joined: true,

            owner: true

        });


        save();


        $("#communityForm").reset();


        closeModal(
            "communityModal"
        );


        renderCommunities();


        toast(
            "Comunidade criada!"
        );

    };




function openChat(type, id) {

    const item =
        (
            type === "group"

                ?

                state.groups

                :

                state.communities
        )
        .find(

            item =>
                item.id === id

        );


    activeChat = {
        type,
        id
    };


    $("#chatTitle").textContent =
        item.name;


    $("#chatType").textContent =
        type === "group"

            ?

            "GRUPO PRIVADO"

            :

            "COMUNIDADE";


    renderChat();


    openModal(
        "chatModal"
    );

}




function renderChat() {

    const key =
        activeChat.type +
        "-" +
        activeChat.id;


    const messages =
        state.messages[key]
        ||
        [];


    $("#chatMessages").innerHTML =
        messages
            .map(

                (message, index) => `

                    <div
                        class="
                            message
                            ${
                                message.me

                                    ?

                                    "me"

                                    :

                                    ""
                            }
                        ">

                        ${esc(message.text)}


                        <small>

                            ${message.time}

                        </small>


                        ${
                            !message.me

                                ?

                                `
                                    <button
                                        class="
                                            message-like
                                        "

                                        data-msg="${index}">

                                        ♡
                                        ${message.likes || 0}

                                    </button>
                                `

                                :

                                ""
                        }

                    </div>

                `

            )
            .join("")


        ||

        `

            <div class="empty">

                <div>
                    💬
                </div>

                <h2>
                    Comece a conversa!
                </h2>

                <p>
                    Envie a primeira mensagem.
                </p>

            </div>

        `;


    $$(".message-like").forEach(button => {

        button.onclick = () => {

            const key =
                activeChat.type +
                "-" +
                activeChat.id;


            state.messages[key]
                [button.dataset.msg]
                .likes =

                (
                    state.messages[key]
                    [button.dataset.msg]
                    .likes

                    ||

                    0
                )
                +
                1;


            save();


            renderChat();

        };

    });


    const chat =
        $("#chatMessages");


    chat.scrollTop =
        chat.scrollHeight;

}




$("#chatForm").onsubmit =
    event => {

        event.preventDefault();


        const text =
            $("#chatText")
                .value
                .trim();


        if (
            !text ||
            !activeChat
        ) {

            return;

        }


        const key =
            activeChat.type +
            "-" +
            activeChat.id;


        state.messages[key] ??= [];


        state.messages[key].push({

            text,

            me: true,

            time:
                new Date()
                    .toLocaleTimeString(

                        "pt-BR",

                        {

                            hour: "2-digit",

                            minute: "2-digit"

                        }

                    )

        });


        save();


        $("#chatText").value =
            "";


        renderChat();

    };




$("#entrarBtn").onclick =
    () => {

        $("#loginPage")
            .classList
            .add("hidden");


        $("#app")
            .classList
            .remove("hidden");


        renderAll();

    };


$("#demoBtn").onclick =
    $("#entrarBtn").onclick;




$("#sairBtn").onclick =
    () => {

        $("#app")
            .classList
            .add("hidden");


        $("#loginPage")
            .classList
            .remove("hidden");

    };



$$(
    ".nav-item[data-page], .text-btn[data-page]"
)
.forEach(button => {

    button.onclick = () => {

        const page =
            button.dataset.page;


        $$(".page")
            .forEach(pageElement => {

                pageElement.classList.remove(
                    "active-page"
                );

            });


        $("#" + page)
            .classList.add(
                "active-page"
            );


        $$(".nav-item")
            .forEach(item => {

                item.classList.toggle(

                    "active",

                    item.dataset.page ===
                    page

                );

            });


        $(".sidebar")
            .classList.remove(
                "open"
            );


        if (
            page === "biblioteca"
        ) {

            renderBooks();

        }

    };

});



$("#mobileMenu").onclick =
    () => {

        $(".sidebar")
            .classList.toggle(
                "open"
            );

    };




$("#openBookModal").onclick =
    () => {

        resetBookForm();

        openModal(
            "bookModal"
        );

    };




$$(
    ".close-modal,[data-close]"
)
.forEach(button => {

    button.onclick = () => {

        closeModal(
            button.dataset.close
        );

    };

});




$$(".filter")
.forEach(button => {

    button.onclick = () => {

        currentFilter =
            button.dataset.filter;


        $$(".filter")
            .forEach(item => {

                item.classList.toggle(

                    "active-filter",

                    item === button

                );

            });


        renderBooks();

    };

});



$("#bookSearch").oninput =
    renderBooks;


$("#globalSearch").oninput =
    () => {

        $("#bookSearch").value =
            $("#globalSearch").value;


        $$(".nav-item[data-page]")
            .forEach(item => {

                item.classList.toggle(

                    "active",

                    item.dataset.page ===
                    "biblioteca"

                );

            });


        $$(".page")
            .forEach(page => {

                page.classList.remove(
                    "active-page"
                );

            });


        $("#biblioteca")
            .classList.add(
                "active-page"
            );


        renderBooks();

    };




$("#bookTotalPages").oninput =
    updatePreview;


$("#bookReadPages").oninput =
    updatePreview;




$("#openCreateGroup").onclick =
    () => {

        openModal(
            "groupModal"
        );

    };


$("#openJoinGroup").onclick =
    () => {

        openModal(
            "joinGroupModal"
        );

    };




$("#openCommunityModal").onclick =
    () => {

        openModal(
            "communityModal"
        );

    };




$$(".community-tab")
.forEach(button => {

    button.onclick = () => {

        communityFilter =
            button.dataset.communityFilter;


        $$(".community-tab")
            .forEach(item => {

                item.classList.toggle(

                    "active",

                    item === button

                );

            });


        renderCommunities();

    };

});




window.onclick =
    event => {

        if (
            event.target.classList.contains(
                "modal"
            )
        ) {

            event.target.classList.remove(
                "show"
            );

        }

    };




function renderAll() {

    renderDashboard();

    renderBooks();

    renderGroups();

    renderCommunities();

}




renderAll();