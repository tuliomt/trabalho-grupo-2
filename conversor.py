import csv, zipfile, re, shutil, math

def calcular(valores=None, calculos=None):
    if valores:
        if valores.__class__.__name__ == 'list' and calculos.__class__.__name__ == 'dict':
            def somar(valores):
                soma = 0
                for v in valores:
                    soma += float(v)
                return soma
 
 
            def media(valores):
                soma = somar(valores)
                qtd_elementos = len(valores)
                media = soma / float(qtd_elementos)
                return media
 
 
            def variancia(valores):
                _media = media(valores)
                soma = 0
                _variancia = 0
 
                for valor in valores:
                    soma += math.pow( (float(valor) - _media), 2)
                _variancia = soma / float( len(valores) )
                return _variancia
 
 
            def desvio_padrao(valores):
                return math.sqrt( variancia(valores) )
                 
 
            calculos['soma'] = somar(valores)
            calculos['media'] = media(valores)
            calculos['variancia'] = variancia(valores)
            calculos['desvio_padrao'] = desvio_padrao(valores)

#DE(m) DN(m) DU(m) PDOP
if __name__ == '__main__':
    data = []
    de = []
    dn = []
    du = []
    pdop = []
    dp = []
    m = []
    calculos = {}
    i = 0

    z = zipfile.ZipFile("scca.zip", "r")

    for filename in z.namelist():
        dia = re.sub('[^0-9]', '', filename.split("/")[1])
        
        with open(z.extract(filename)) as f:
            line = f.readlines()
            lines = []
            
            if len(line) > 1:
                lines.append([word.strip() for word in line[0].split() if word])
                
                for l in line[1:]:
                    l = [word.strip() for word in l.split() if word]
                    
                    if len(l) > lines[0].index("PDOP"):
                        lines.append(l)
            
                calcular([x[lines[0].index("DE(m)")] for x in lines[1:]], calculos)
                dp.append([dia, calculos['desvio_padrao']])
                m.append([dia, calculos['media']])
                calcular([x[lines[0].index("DN(m)")] for x in lines[1:]], calculos)
                dp[i].append(calculos['desvio_padrao'])
                m[i].append(calculos['media'])
                calcular([x[lines[0].index("DU(m)")] for x in lines[1:]], calculos)
                dp[i].append(calculos['desvio_padrao'])
                m[i].append(calculos['media'])
                calcular([x[lines[0].index("PDOP")] for x in lines[1:]], calculos)
                dp[i].append(calculos['desvio_padrao'])
                m[i].append(calculos['media'])
                i = i + 1
                
                de.append([dia, lines[-1][lines[0].index("DE(m)")]])
                dn.append([dia, lines[-1][lines[0].index("DN(m)")]])
                du.append([dia, lines[-1][lines[0].index("DU(m)")]])
                pdop.append([dia, lines[-1][lines[0].index("PDOP")]])

    with open('de.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(de)

    with open('dn.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(dn)

    with open('du.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(du)

    with open('pdop.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(pdop)

    with open('dp.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(dp)

    with open('m.csv', 'w') as out_file:
        writer = csv.writer(out_file)
        writer.writerows(m)

    shutil.rmtree("sccagim")
