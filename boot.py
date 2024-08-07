import os
def processarresposta(resposta, nome):
    if resposta == "1":
        print(f'{nome}{os.linesep}, teste')
    elif resposta == "2":
        print(f'{nome}{os.linesep}, teste2')
    elif resposta == "3":
        print(f'{nome}{os.linesep}, teste3')
    elif resposta == "4":
        print(f'{nome}{os.linesep}, teste4')
    elif resposta == "5":
        print(f'{nome}{os.linesep}, teste5')
    elif resposta == "6":
        print(f'{nome}{os.linesep}, teste6')
    else:
        print(f'{nome}{os.linesep}, digite apenas 1,2,3,4,5,6')

def start():
    print ("ola tudo bem ?")
    nome = input('Digite seu nome: ')
    email = input('Digite seu e-mail: ')
    while True:
        resposta=input(f'O que gostaria de saber hoje?{os.linesep}[1]-Como instar um banco de dados ?'
        "{os.linesep}[2]-Como criar uma tabela de banco de dados") 
        
        processarresposta(resposta,nome)


if __name__ == '__main__':
    start()
