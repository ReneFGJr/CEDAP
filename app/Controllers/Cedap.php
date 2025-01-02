<?php
//https://htmlcolorcodes.com/

namespace App\Controllers;

use App\Controllers\BaseController;

$this->session = \Config\Services::session();
$language = \Config\Services::language();

define("MODULE","cedap");

helper(['boostrap','url','graphs','sisdoc_forms','form']);

function cr()
	{
		return chr(13).chr(10);
	}

class Cedap extends BaseController
{
    var $bg = '#9009A8';
	// https://www.richdataservices.com/showcase

	public function __construct()
	{
		$this->Socials = new \App\Models\Socials();

		helper(['boostrap','url','canvas']);
		define("PATH", "index.php/cedap/");
		define("LIBRARY", "CEDAP_LABS");
		define("LIBRARY_NAME", "");
	}

	private function cab($dt=array())
		{
			$title = 'Brapci3 - DrashDataBoard';
			if (isset($dt['title'])) { $title = $dt['title']; }
			$sx = '<!doctype html>'.cr();
			$sx .= '<html>'.cr();
			$sx .= '<head>'.cr();
			$sx .= '<title>'.$title.'</title>'.cr();
			$sx .= '  <meta charset="utf-8" />'.cr();
			$sx .= '  <link rel="apple-touch-icon" sizes="180x180" href="'.base_url('favicon.ico').'" />'.cr();
			$sx .= '  <link rel="icon" type="image/png" sizes="32x32" href="'.base_url('favicon.ico').'" />'.cr();
			$sx .= '  <link rel="icon" type="image/png" sizes="16x16" href="'.base_url('favicon.ico').'" />'.cr();
			$sx .= '  <!-- CSS -->'.cr();
			$sx .= '  <link rel="stylesheet" href="'.base_url('/css/bootstrap.css').'" />'.cr();
			$sx .= '  <link rel="stylesheet" href="'.base_url('/css/style.css?v0.0.9').'" />'.cr();
			$sx .= ' '.cr();
			$sx .= '  <!-- CSS -->'.cr();
			$sx .= '  <script src="'.base_url('/js/bootstrap.js?v=5.0.2').'"></script>'.cr();
			$sx .= '</head>'.cr();
			return $sx;

		}

	private function navbar($dt=array())
		{
			$title = 'CEDAP Labs';
			if (isset($dt['title'])) { $title = $dt['title']; }
			$sx = '<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: '.$this->bg.'">'.cr();
			$sx .= '  <div class="container-fluid">'.cr();
			$sx .= '    <a class="navbar-brand" href="'.base_url().'">'.$title.'</a>'.cr();
			$sx .= '    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">'.cr();
			$sx .= '      <span class="navbar-toggler-icon"></span>'.cr();
			$sx .= '    </button>'.cr();
			$sx .= '    <div class="collapse navbar-collapse" id="navbarSupportedContent">'.cr();
			$sx .= '      <ul class="navbar-nav me-auto mb-2 mb-lg-0">'.cr();
			/*
			$sx .= '        <li class="nav-item">'.cr();
			$sx .= '          <a class="nav-link active" aria-current="page" href="#">Home</a>'.cr();
			$sx .= '        </li>'.cr();
			$sx .= '        <li class="nav-item">'.cr();
			$sx .= '          <a class="nav-link" href="#">Link</a>'.cr();
    		$sx .= '		</li>'.cr();
			*/
			$sx .= '        <li class="nav-item dropdown">'.cr();
			$sx .= '          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.cr();
			$sx .= '            '.lang('brapci.Labs').cr();
			$sx .= '          </a>'.cr();
			$sx .= '          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">'.cr();
			$sx .= '            <li><a class="dropdown-item" href="'.base_url('brapci/labs').'">'.lang('brapci.Labs.Drashboard').'</a></li>'.cr();
			$sx .= '            <li><a class="dropdown-item" href="'.base_url('brapci/ontology').'">'.lang('brapci.Labs.Ontology').'</a></li>'.cr();
			$sx .= '            <li><a class="dropdown-item" href="'.base_url('brapci/analysis').'">'.lang('brapci.Labs.Analysis').'</a></li>'.cr();
			$sx .= '          </ul>'.cr();
			$sx .= '        </li>'.cr();

			$sx .= '        <li class="nav-item dropdown">'.cr();
			$sx .= '          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">'.cr();
			$sx .= '            '.lang('brapci.Analyse').cr();
			$sx .= '          </a>'.cr();
			$sx .= '          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">'.cr();
			$sx .= '            <li><a class="dropdown-item" href="#">'.lang('brapci.Analyse.Drashboard').'</a></li>'.cr();
			$sx .= '            <li><a class="dropdown-item" href="#">Another action</a></li>'.cr();
			$sx .= '            <li><hr class="dropdown-divider"></li>'.cr();
			$sx .= '            <li><a class="dropdown-item" href="#">Something else here</a></li>'.cr();
			$sx .= '          </ul>'.cr();
			$sx .= '        </li>'.cr();

			$sx .= '        <li class="nav-item dropdown">' . cr();
			$sx .= '          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . cr();
			$sx .= '            ' . lang('brapci.DCI') . cr();
			$sx .= '          </a>' . cr();
			$sx .= '          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">' . cr();
			$sx .= '            <li><a class="dropdown-item" href="'.base_url('/dci/cursos').'">' . lang('brapci.Encargos.Cursos') . '</a></li>' . cr();
			$sx .= '            <li><a class="dropdown-item" href="#">' . lang('brapci.Encargos.Drashboard') . '</a></li>' . cr();
			$sx .= '            <li><hr class="dropdown-divider"></li>' . cr();
			$sx .= '            <li><a class="dropdown-item" href="#">' . lang('brapci.Encargos.Drashboard') . '</a></li>' . cr();
			$sx .= '          </ul>' . cr();
			$sx .= '        </li>' . cr();


			$sx .= '      </ul>'.cr();

			/*
			$sx .= '        <li class="nav-item">'.cr();
			$sx .= '          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>'.cr();
			$sx .= '        </li>'.cr();
			$sx .= '      </ul>'.cr();
			*/

			/*
			$sx .= '      <form class="d-flex">'.cr();
			$sx .= '        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">'.cr();
			$sx .= '        <button class="btn btn-outline-success" type="submit">Search</button>'.cr();
			$sx .= '      </form>'.cr();
			*/

			$sx .= $this->Socials->nav_user();

			$sx .= '    </div>'.cr();
			$sx .= '  </div>'.cr();
			$sx .= '</nav>'.cr();
			return $sx;
		}


	private function footer()
		{
			$sx = '<!-- Footer -->
					<footer class="page-footer font-small blue-grey lighten-5" style="margin-top: 50px;">

					<div style="background-color: '.$this->bg.';">
						<div class="container">

						<!-- Grid row-->
						<div class="row py-4 d-flex align-items-center">

							<!-- Grid column -->
							<div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
							<h6 class="mb-0">Get connected with us on social networks!</h6>
							</div>
							<!-- Grid column -->

							<!-- Grid column -->
							<div class="col-md-6 col-lg-7 text-center text-md-right">

							<!-- Facebook -->
							<a class="fb-ic">
								<i class="fab fa-facebook-f white-text mr-4"> </i>
							</a>
							<!-- Twitter -->
							<a class="tw-ic">
								<i class="fab fa-twitter white-text mr-4"> </i>
							</a>
							<!-- Google +-->
							<a class="gplus-ic">
								<i class="fab fa-google-plus-g white-text mr-4"> </i>
							</a>
							<!--Linkedin -->
							<a class="li-ic">
								<i class="fab fa-linkedin-in white-text mr-4"> </i>
							</a>
							<!--Instagram-->
							<a class="ins-ic">
								<i class="fab fa-instagram white-text"> </i>
							</a>

							</div>
							<!-- Grid column -->

						</div>
						<!-- Grid row-->

						</div>
					</div>

					<!-- Footer Links -->
					<div class="container text-center text-md-left mt-5">

						<!-- Grid row -->
						<div class="row mt-3 dark-grey-text">

						<!-- Grid column -->
						<div class="col-md-3 col-lg-4 col-xl-3 mb-4">

							<!-- Content -->
							<h6 class="text-uppercase font-weight-bold">'.lang('social.COMPANY NAME').'</h6>
							<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
							<p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet,
							consectetur
							adipisicing elit.</p>

						</div>
						<!-- Grid column -->

						<!-- Grid column -->
						<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

							<!-- Links -->
							<h6 class="text-uppercase font-weight-bold">'.lang('social.Products').'</h6>
							<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
							<p>
							<a class="dark-grey-text" href="#!">MDBootstrap</a>
							</p>
							<p>
							<a class="dark-grey-text" href="#!">MDWordPress</a>
							</p>
							<p>
							<a class="dark-grey-text" href="#!">BrandFlow</a>
							</p>
							<p>
							<a class="dark-grey-text" href="#!">Bootstrap Angular</a>
							</p>

						</div>
						<!-- Grid column -->

						<!-- Grid column -->
						<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

							<!-- Links -->
							<h6 class="text-uppercase font-weight-bold">'.lang('social.Useful_links').'</h6>
							<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
							<p>
							<a class="dark-grey-text" href="#!">'.lang('social.profile').'</a>
							</p>
							<p>
							<a class="dark-grey-text" href="#!">'.lang('social.help').'</a>
							</p>

						</div>
						<!-- Grid column -->

						<!-- Grid column -->
						<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

							<!-- Links -->
							<h6 class="text-uppercase font-weight-bold">'.lang('social.Contact').'</h6>
							<hr class="teal accent-3 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
							<p>
							<i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
							<p>
							<i class="fas fa-envelope mr-3"></i> info@example.com</p>
							<p>
							<i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
							<p>
							<i class="fas fa-print mr-3"></i> + 01 234 567 89</p>

						</div>
						<!-- Grid column -->

						</div>
						<!-- Grid row -->

					</div>
					<!-- Footer Links -->

					<!-- Copyright -->
					<div class="footer-copyright text-center text-black-50 py-3">© 2019-'.date("Y").' Copyright:
						<a class="dark-grey-text" href="https://github.com/ReneFGJr/Cedap" target="_github">GitHub / ReneFGJr / Cedap </a>
					</div>
					<!-- Copyright -->

					</footer>
					<!-- Footer -->';
			return $sx;
		}

	public function social($d1 = '', $id = '')
	{
		$cab = $this->cab();
		$dt = array();
		$sx = $this->Socials->index($d1,$id,$dt,$cab);
		return $sx;
	}

	public function index($d1='',$d2='')
	{
		//
		$tela = $this->cab();
		$tela .= $this->navbar();
		$dt = array();
		$d[0] = array('image'=>base_url('img/banner/banner_cedap_01.jpg'),'link'=>'');
		$d[1] = array('image'=>'https://images3.alphacoders.com/102/102609.jpg','link'=>'');
		$d[2] = array('image'=>'https://static.escolakids.uol.com.br/2019/07/paisagem-natural-e-paisagem-cultural.jpg','link'=>'');

		$tela .= bscarousel($d);

		#### Logado
		if (isset($_SESSION['user']))
			{
                $ScanProject = new \App\Models\ScanProject();
				$tela .= bs(bsc($ScanProject->index(),12));
			} else {
				$login = $this->Socials->login(0);
        		$tela .= bs(h('Drashboard',1),array('fluid'=>0,'g'=>5));
        		$tela .= bs(
						bsc(bscard('Hello'),4).
						bsc(bscard('Hello'),4).
						bsc($login,4)
					);
            }
		$tela .= $this->footer($d);
		return $tela;
	}

	public function project($d1='',$d2='',$d3='')
	{
		//
		$tela = $this->cab();
		$tela .= $this->navbar();

        $ScanProject = new \App\Models\ScanProject();
        $tela .= bs(bsc($ScanProject->index($d1,$d2,$d3),12));

		#### Rodape - Footer
        $tela .= $this->footer();
        return $tela;
	}

    public function image($id,$id2='',$id3='')
        {
            $ScanProjectFile = new \App\Models\ScanProjectFile();
            $ScanProjectFile->image($id,$id2,$id3);
        }

}
