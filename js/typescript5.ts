const searchBox = <HTMLInputElement>document.getElementById("userSearch");

const searchResults = <HTMLElement>document.getElementById("searchResults");

searchBox?.addEventListener("change", () => {

    const searchQuery: string = searchBox.value.toLowerCase();

    console.log(searchQuery);

    if(searchQuery) {
        
        fetch("https://jsonplaceholder.typicode.com/users")
        .then(response => response.json())
        .then(users => {

            const userFound = users.find(
                user => user.name.toLowerCase().includes(searchQuery)
            );

            if(userFound) {
                searchResults.innerHTML = `
                    <dl>
                        <dt>Nome</dt>
                        <dd>${userFound.name}</dd>
                        <dt>Username</dt>
                        <dd>${userFound.username}</dd>
                        <dt>Email</dt>
                        <dd>${userFound.email}</dd>
                    </dl>
                `;
            }
            else {
                searchResults.innerHTML = `<p role="alert">Não foram encontrados resultados</p>`;
            }
        });
    }

});

