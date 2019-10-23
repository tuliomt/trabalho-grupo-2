import re
import string
import os

# Coloque os seus parametros aqui...
diretorio = "\TulioAraujo\Desktop\teste"
extensao = ".*out"
novaExtensao = ".txt"  # nesse caso eh vazia
parteQueSai = "IM-0001-"
parteQueSubstitui = "slice"

# Muda extensao
reg = re.compile(extensao)
if os.path.isdir(diretorio) and not os.path.islink(diretorio):
    arquivos = os.listdir(diretorio)
    for arquivo in arquivos:
        newExt = re.compile(extensao).match
        if newExt(arquivo):
            c = os.path.splitext(arquivo)
            b = c[0] + novaExtensao
            a = os.path.join(diretorio,arquivo)
            b = os.path.join(diretorio,b)
            os.rename(a,b)

# Modifica nome
if os.path.isdir(diretorio) and not os.path.islink(diretorio):
    arquivos = os.listdir(diretorio)
    for arquivo in arquivos:
        print (arquivo)
        novoNome = string.replace(arquivo, parteQueSai, parteQueSubstitui)
        fullpathOld = os.path.join(diretorio,arquivo)
        fullpathNew = os.path.join(diretorio,novoNome)
        os.rename(fullpathOld, fullpathNew)


