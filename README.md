# Glossário

Um plugin em WordPress que sirva como um glossário para traduções de termos e
para a discussão colaborativa desses verbetes. [Siga a discussão
inicial](http://participe.wp-brasil.org/2014/12/13/pessoal-voces-que-estao-nessa-vibe-de-fazer/).

## Terminologia

Tanto o WordPress quanto os glossários baseiam-se na palavra _termo_ (_term_ no
inglês), então explicando:

No WordPress um _termo_ é um item editorial cujo significado é dado pela sua
[_taxonomia_](http://codex.wordpress.org/WordPress_Taxonomy) -- tal como as
categorias e as tags que existem por padrão na ferramenta e possuem a principal
finalidade de classificação dos posts.

Na linguística, termo é a representação de uma
[palavra](http://pt.wikipedia.org/wiki/Palavra):

> Quando nos referimos à palavra enquanto índice da ideia que ela representa
> (ou seja: quando falamos do sentido por trás da palavra escrita ou falada),
> estamos nos referindo ao aspecto interno ou representação imaterial da
> palavra, e a este aspecto interno, imaterial, damos o nome de termo.

Neste `README` estamos nos referindo aos _termos de um glossário_.

## Propósitos

Um plugin administrado exclusivamente pelo admin do WordPress com um _custom
post type_ para exibição de um glossário de traduções, exibindo a palavra que
deve ser utilizada para determinados contextos de tradução.

O objetivo da manutenção de um glossário para traduções é ter uma base de
referência para traduções colaborativas de projetos que utilizem o sistema
[gettext](http://www.gnu.org/software/gettext/).

Para as Comunidades Brasileira e Portuguesa de WordPress, o objetivo específico
é possibilitar e incentivar a colaboratividade das traduções, oferecendo uma
base de referência para realização de traduções das novas versões do WordPress
conforme as discussões já realizadas nas comunidades quanto à forma e
significado dos termos envolvidos.

Este trabalho foi proposto inicialmente devido aos glossários já existentes da
[Comunidade Brasileira](http://wp-brasil.org/glossario/) e da [Comunidade
Portuguesa](http://palheta.wp-portugal.com/glossario-ingles-portugues-pos-acordo-ortografico-draft/).

## Especificação inicial

#### Custom post type `glossary_term`

Este _custom post type_ serve para os termos a serem traduzidos e possuem os
seguintes campos:

* Termo original
* Plural do termo original
* Tradução do termo
* Tradução do plural do termo
* Notas sobre a tradução

#### Taxonomias envolvidas:

* Idioma
* Classes morfológica (artigo, substantivo, verbo, adjetivo)
* Estado da tradução (consolidado, aberto para sugestões)

#### Comentários

* Os comentários para cada post do tipo `glossary_term` devem estar habilitados
  para que seja possível realizar uma discussão e fazer novas propostas de
  tradução.

#### Propostas de funcionalidades adicionais:

* Shortcodes para exibição de uma lista com busca e significado dos termos --
  com link para edição no admin para quem tiver acesso
* Cadastro de arquivos PO para mapeamento dos termos do glossários em traduções
  completas dos projetos da comunidade -- não envolve funcionalidade de edição
  de arquivos PO, somente exibição de onde o termo em questão aparece nas
  traduções. Isto pode ser útil ao se modificar um novo termo e para se
  realizar a tradução de uma nova _string de tradução_ conforme as referências
  do glossário.
