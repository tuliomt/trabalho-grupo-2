# Entrevistado: Leonardo Miquelutti

## Data da reunião: 23/08/2019 Início às 11:00h e termino as 11:55h.

### Entrevistado:
Atualmente, professor visitante na UFU, onde leciona Geofísica para a graduação em Geologia. Sócio da UnderGeo,
uma consultora na área de geofísica, geologia e pesquisa. Bacharel e licenciado em física pela Unicamp, com mestrado e doutorado 
em geofísica pelo Observatório Nacional, situado no Rio de Janeiro. Durante a minha pós-graduação, se especializou no método
magneto telúrico de prospecção, um método extremamente limpo e eficaz. Durante o mestrado e doutorado direcionou esforços para 
programação, com ênfase em processamento de dados magneto telúricos através de computação paralela em GPUs, usando CUDA/C++. 
No papel de geofísico (e também doutorando) em um instituto de pesquisa do Governo Federal, possuí diversas atribuições, como 
geofísico de campo, gerenciamento de equipes, controle de qualidade, processamento de dados, inversão e interpretação, tutor em 
cursos especializados, além de diversos afazeres computacionais. Desenvolvia códigos para atender a demanda de pesquisadores de 
um grupo do qual fazia parte. Atuou diretamente em projetos de P,D&I em parceria com empresas de O&G e órgãos regulatórios. Como 
doutorando, propos uma nova metodologia saber a orientação de sensores eletromagnéticos jogados no fundo do mar, desenvolveu uma 
biblioteca amigável para operações vetoriais/matriciais diversas usando GPUs através da arquitetura CUDA, e por último escreveu 
um programa em C++ para processamento de dados magneto telúricos que fez uso dessa biblioteca. Finalmente, como programador, se 
especializou em Matlab, C/C++ e CUDA. Tem experiência com diversas bibliotecas, como boost, blas, lapack, fftw, e suas 
correspondentes da Nvidia. Durante alguns anos lecionou disciplinas relacionadas a geofísica para a graduação da Engenharia de
Petróleo e Gás de duas universidades privadas distintas, além de minicursos em Matlab.

### Tópicos discutidos:
Leonardo expos de forma rápida e resumida todo o seu projeto para captar dados de sensores e através de um software escrito em c++
de autoria própria que é capaz de ler estes dados, computa-los e processar para uso e analise de profissionais da área. 
Pretende também fazer melhorias nas bibliotecas e códigos. E criar um software todo documentado e personalizável, voltado para
processamento de dados geofísicos, com um wizard de instalação onde será possível que outros pesquisadores da área possam também 
utilizar as ferramentas já desenvolvidas pela equipe do professor Leonardo.

### Documentos associados à fase de Concepção do Projeto:
O matCUDA: tentar imitar o MatLab em C++, usando programação em GPU
1 - a melhoria de uma biblioteca C++ para realização de operações algébricas com a facilidade do matlab.
https://github.com/leomiquelutti/matCUDA
O mtaas é o início de um projeto SaaS para processamento de dados de um método geofísico. em C++ também, e usa a versão 1.0 da matCUDA.
2 - a melhoria de um programa de processamento de dados de um método geofísico chamado magnetotelúrico, que usa a biblioteca acima.
https://github.com/leomiquelutti/mtaas
