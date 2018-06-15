
					
					<table>
					<td>
						<tr><h3>'.$row['Titolo'].'</h3></tr>
						<tr>
							<p id="data" >Data '.$row['Data'].' h: '.$row['OraInizio'].'</p>
						</tr>
						<tr>
						 <p>Stato : '.$row['Stato'].' </p>
						</tr>
						<tr>
							<td><p id="pos" >Pos: Via LoremIpsum 32/C </p></td>
							<td><button onclick="mostraMappaFunction()"> Mostra mappa</button></td>
						</tr>
						<tr >
							<td colspan="2"> 
								<p id="desc" >'.$row['Descrizione']'</p>
							</td>
						</tr>
						
						<tr>
							<td>
								<button>Aggiungi ad un tuo Percorso</button>
							</td>
							<td>
								<button>Commenta</button>
							</td>
						</tr>
					</td>
				</table>
				
			