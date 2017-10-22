<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskForm;
use AppBundle\Services\Paginator;
use Doctrine\Common\Proxy\Exception\UnexpectedValueException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    private $paginator;
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function indexAction(Request $request)
    {
        $page = $request->query->get('page') ? (int)$request->query->get('page') : 1;
        if((int)$page > 0) {
            $this->paginator->init($page, 5, $this->getDoctrine()->getRepository('AppBundle:Task'),$this->getUser());
            $tasks = $this->paginator->paginate();
            $next_tasks = $this->paginator->getNextPage();
            $previous_tasks = $this->paginator->getPreviousPage();
            return $this->render('AppBundle:Task:index.html.twig', ['tasks' => $tasks, 'next_tasks' => $next_tasks, 'previous_tasks' => $previous_tasks, 'page' => $page]);
        }
        throw new UnexpectedValueException('Page number cannot be below 0');
    }

    public function createAction()
    {
        $form = $this->createForm(TaskForm::class);
        return $this->render('AppBundle:Task:create.html.twig', ['form' => $form->createView()]);
    }

    public function storeAction(Request $request)
    {
            $task = new Task();
            $em = $this->getDoctrine()->getManager();
            $task->setContent($request->request->get('app_bundle_task_form')['content'])->setActive(true)->setDate(new \DateTime('now'));
            $task->setUser($this->getUser());
            $em->persist($task);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your task was saved!'
            );
            return $this->redirectToRoute('index');
    }

    public function deleteAction(Task $id)
    {
        if ($this->isGranted('delete', $id)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($id);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your task was deleted successfully!'
            );

        }    return $this->redirectToRoute('index');
    }
}
