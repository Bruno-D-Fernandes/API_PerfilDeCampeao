export default class DataTable {
    constructor(config) {
        this.tableId = config.tableId;
        this.apiUrl = config.apiUrl;
        this.renderRow = config.renderRow;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.tokenKey = config.tokenKey || 'clube_token';

        this.state = {
            page: 1,
            perPage: 15,
            search: '',
            sortCol: null,
            sortDir: 'neutral'
        };

        this.container = document.getElementById(this.tableId);

        if (!this.container) {
            console.error(`Tabela #${this.tableId} não encontrada.`);
            return;
        }

        this.tbody = this.container.querySelector('.table-body');
        this.headers = this.container.querySelectorAll('.sortable-column');
        this.searchInput = this.container.querySelector('input[type="search"]') || this.container.querySelector('input[type="text"]');
        this.paginationContainer = this.container.querySelector('.pagination-container');
        
        this.styles = {
            btnBase: "flex items-center justify-center w-[1.88vw] h-[1.88vw] text-[0.73vw] transition-colors cursor-pointer",
            btnActive: "bg-gray-200 text-gray-900 font-medium border border-[0.052vw] border-gray-300",
            btnInactive: "bg-gray-50 text-gray-500 font-medium border border-[0.052vw] border-gray-300 hover:bg-gray-200 hover:text-gray-700",
            navBtnBase: "cursor-pointer flex items-center justify-center border border-[0.052vw] border-gray-300 font-medium px-[0.63vw] h-[1.88vw] transition-colors",
            navBtnActive: "bg-gray-50 text-gray-500 hover:bg-gray-200 hover:text-gray-700",
            navBtnDisabled: "bg-gray-100 text-gray-400 cursor-not-allowed",
            dots: "flex items-center justify-center bg-white text-gray-500 border border-[0.052vw] border-gray-300 font-medium w-[1.88vw] h-[1.88vw]"
        };

        this.init();
    }

    init() {
        this.headers.forEach(th => {
            th.addEventListener('click', () => {
                const colName = th.getAttribute('data-col');
                this.handleSort(colName, th);
            });
        });

        if (this.searchInput) {
            let timeout;
            this.searchInput.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.state.search = e.target.value;
                    this.state.page = 1;
                    this.fetchData();
                }, 500);
            });
        }

        this.fetchData();
    }

    handleSort(colName, thElement) {
        let newDir = 'asc';

        if (this.state.sortCol === colName) {
            if (this.state.sortDir === 'asc') newDir = 'desc';
            else if (this.state.sortDir === 'desc') newDir = 'neutral';
        }

        this.headers.forEach(h => this.updateHeaderIcon(h, 'neutral'));

        if (newDir !== 'neutral') {
            this.updateHeaderIcon(thElement, newDir);
            this.state.sortCol = colName;
            this.state.sortDir = newDir;
        } else {
            this.state.sortCol = null;
            this.state.sortDir = 'neutral';
        }

        this.fetchData();
    }

    updateHeaderIcon(th, dir) {
        const neutral = th.querySelector('.icon-neutral');
        const asc = th.querySelector('.icon-asc');
        const desc = th.querySelector('.icon-desc');

        if (!neutral) return;

        neutral.classList.add('hidden');
        asc.classList.add('hidden');
        desc.classList.add('hidden');

        if (dir === 'asc') asc.classList.remove('hidden');
        else if (dir === 'desc') desc.classList.remove('hidden');
        else neutral.classList.remove('hidden');
    }

    async fetchData() {
        const params = new URLSearchParams({
            page: this.state.page,
            per_page: this.state.perPage,
            search: this.state.search
        });

        if (this.state.sortCol && this.state.sortDir !== 'neutral') {
            params.append('sort_col', this.state.sortCol);
            params.append('sort_dir', this.state.sortDir);
        }

        try {
            this.tbody.style.opacity = '0.5';

            const headers = {
                "Accept": "application/json"
            };

            const token = localStorage.getItem(this.tokenKey);

            if (token) {
                headers['Authorization'] = `Bearer ${token}`;
            } else {
                if (this.csrfToken) {
                    headers['X-CSRF-TOKEN'] = this.csrfToken;
                }
            }

            const response = await fetch(`${this.apiUrl}?${params.toString()}`, {
                method: 'GET',
                headers: headers
            });

            if (!response.ok) throw new Error();
            const data = await response.json();

            const rows = data.data ? data.data : data; 
            
            this.renderRows(rows);
            this.renderPagination(data);

        } catch (error) {
            console.error(error);
            this.tbody.innerHTML = '<tr><td colspan="100%" class="p-4 text-center text-red-500">Erro ao carregar dados.</td></tr>';
        } finally {
            this.tbody.style.opacity = '1';
        }
    }

    renderRows(rows) {
        this.tbody.innerHTML = '';
        if (rows.length === 0) {
            this.tbody.innerHTML = '<tr><td colspan="100%" class="p-4 text-center text-gray-500">Nenhum registro encontrado.</td></tr>';
            return;
        }
        rows.forEach(row => {
            this.tbody.innerHTML += this.renderRow(row);
        });
    }

    calculatePages(current, max) {
        if (max <= 7) {
            return Array.from({ length: max }, (_, i) => i + 1);
        }

        const start = Math.max(2, current - 1);
        const end = Math.min(max - 1, current + 1);
        const pages = [1];

        if (start > 2) {
            pages.push('...');
        }

        for (let i = start; i <= end; i++) {
            pages.push(i);
        }

        if (end < max - 1) {
            pages.push('...');
        }

        pages.push(max);
        return pages;
    }

    renderPagination(meta) {
        if (!this.paginationContainer || !meta.last_page) return;

        const current = meta.current_page;
        const max = meta.last_page;
        const pages = this.calculatePages(current, max);

        let html = `
            <div class="flex items-center justify-between w-full gap-[0.83vw]">
                <nav>
                    <ul class="flex -space-x-[0.052vw] text-[0.73vw]">
                        
                        <!-- Botão Anterior -->
                        <li>
                            <button type="button" data-action="prev"
                                class="${this.styles.navBtnBase} rounded-s-[0.42vw] ${current > 1 ? this.styles.navBtnActive : this.styles.navBtnDisabled}"
                                ${current === 1 ? 'disabled' : ''}>
                                Anterior
                            </button>
                        </li>
        `;

        pages.forEach(page => {
            html += `<li>`;
            
            if (page === '...') {
                html += `<span class="${this.styles.dots}">...</span>`;
            } else {
                const isActive = page === current;
                const style = isActive ? this.styles.btnActive : this.styles.btnInactive;
                
                html += `
                    <button type="button" data-page="${page}" 
                        class="${this.styles.btnBase} ${style}">
                        ${page}
                    </button>
                `;
            }
            html += `</li>`;
        });

        html += `
                        <!-- Botão Próximo -->
                        <li>
                            <button type="button" data-action="next"
                                class="${this.styles.navBtnBase} rounded-e-[0.42vw] ${current < max ? this.styles.navBtnActive : this.styles.navBtnDisabled}"
                                ${current === max ? 'disabled' : ''}>
                                Próxima
                            </button>
                        </li>
                    </ul>
                </nav>

                <!-- Select Por Página -->
                <div class="w-[7.92vw]">
                    <select class="per-page-select block w-full px-[0.63vw] py-[0.52vw] border border-[0.052vw] border-gray-300 text-gray-700 font-medium text-[0.73vw] rounded-[0.42vw] focus:ring-[0.052vw] focus:ring-gray-300 focus:border-gray-300 shadow-xs">
                        ${[10, 25, 50, 100].map(limit => 
                            `<option value="${limit}" ${this.state.perPage == limit ? 'selected' : ''}>${limit} por página</option>`
                        ).join('')}
                    </select>
                </div>
            </div>
        `;

        this.paginationContainer.innerHTML = html;

        this.bindPaginationEvents(current, max);
    }

    bindPaginationEvents(current, max) {
        this.paginationContainer.querySelectorAll('button[data-page]').forEach(btn => {
            btn.addEventListener('click', () => {
                this.state.page = parseInt(btn.dataset.page);
                this.fetchData();
            });
        });

        const prevBtn = this.paginationContainer.querySelector('button[data-action="prev"]');
        if (prevBtn && !prevBtn.disabled) {
            prevBtn.addEventListener('click', () => {
                this.state.page = current - 1;
                this.fetchData();
            });
        }

        const nextBtn = this.paginationContainer.querySelector('button[data-action="next"]');
        if (nextBtn && !nextBtn.disabled) {
            nextBtn.addEventListener('click', () => {
                this.state.page = current + 1;
                this.fetchData();
            });
        }

        const select = this.paginationContainer.querySelector('.per-page-select');
        if (select) {
            select.addEventListener('change', (e) => {
                this.state.perPage = e.target.value;
                this.state.page = 1;
                this.fetchData();
            });
        }
    }
}